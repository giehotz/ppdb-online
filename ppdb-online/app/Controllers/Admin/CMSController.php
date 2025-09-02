<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CMSModel;
use App\Models\UserModel;

class CMSController extends BaseController
{
    protected $cmsModel;
    protected $userModel;

    public function __construct()
    {
        $this->cmsModel = new CMSModel();
        $this->userModel = new UserModel();
    }

    /**
     * Show the CMS posts list
     */
    public function index()
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $posts = $this->cmsModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title' => 'Manajemen Konten',
            'posts' => $posts
        ];

        return view('admin/cms/index', $data);
    }

    /**
     * Show the form to create or edit a post
     */
    public function form($id = null)
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $post = null;
        if ($id) {
            $post = $this->cmsModel->find($id);
            if (!$post) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException("Konten dengan ID $id tidak ditemukan");
            }
        }

        $data = [
            'title' => $id ? 'Edit Konten' : 'Tambah Konten',
            'post' => $post
        ];

        return view('admin/cms/form', $data);
    }

    /**
     * Save or update a post
     */
    public function save()
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $id = $this->request->getPost('id');
        
        $data = [
            'type' => $this->request->getPost('type'),
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'status' => $this->request->getPost('status'),
            'publish_at' => $this->request->getPost('publish_at'),
            'author_id' => session()->get('user_id'),
        ];
        
        // Generate slug from title
        $slug = url_title($this->request->getPost('title'), '-', true);
        $data['slug'] = $slug;
        
        // Check if slug already exists (for new posts or when title changes)
        if (!$id || ($id && $this->cmsModel->find($id)['title'] !== $this->request->getPost('title'))) {
            // Make sure slug is unique
            $originalSlug = $slug;
            $counter = 1;
            
            while ($this->cmsModel->where('slug', $slug)->where('id !=', $id)->first()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $data['slug'] = $slug;
        }

        // Validate data
        if (!$this->cmsModel->validate($data)) {
            $errors = $this->cmsModel->errors();
            $errorMessage = implode(', ', $errors);
            return $this->response->setJSON(['status' => 'error', 'message' => $errorMessage]);
        }

        // Save or update post
        if ($id) {
            // Update existing post
            $data['id'] = $id;
            if ($this->cmsModel->save($data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Konten berhasil diperbarui.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui konten.']);
            }
        } else {
            // Create new post
            if ($this->cmsModel->save($data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Konten berhasil disimpan.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan konten.']);
            }
        }
    }

    /**
     * Delete a post
     */
    public function delete($id)
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        if ($this->cmsModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Konten berhasil dihapus.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menghapus konten.']);
        }
    }
}