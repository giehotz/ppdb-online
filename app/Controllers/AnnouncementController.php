<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;

class AnnouncementController extends BaseController
{
    protected $announcementModel;
    
    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
    }
    
    /**
     * Show list of announcements (for students)
     *
     * @return string
     */
    public function index()
    {
        $announcements = $this->announcementModel->getAll();
        
        return view('announcement/index', [
            'title' => 'Daftar Pengumuman',
            'announcements' => $announcements
        ]);
    }
    
    /**
     * Show announcement detail
     *
     * @param int $id
     * @return string
     */
    public function detail($id)
    {
        $announcement = $this->announcementModel->getById($id);
        
        if (!$announcement) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengumuman tidak ditemukan');
        }
        
        return view('announcement/detail', [
            'title' => $announcement['title'],
            'announcement' => $announcement
        ]);
    }
    
    /**
     * Show form to create announcement (admin/panitia only)
     *
     * @return string
     */
    public function create()
    {
        // Check if user has admin or panitia role
        if (!in_array(session()->get('role'), ['admin', 'panitia'])) {
            return redirect()->back()->with('error', 'Akses ditolak. Hanya admin dan panitia yang dapat menambah pengumuman.');
        }
        
        return view('admin/announcement/form', [
            'title' => 'Tambah Pengumuman',
            'validation' => \Config\Services::validation()
        ]);
    }
    
    /**
     * Save new announcement (admin/panitia only)
     *
     * @return mixed
     */
    public function store()
    {
        // Check if user has admin or panitia role
        if (!in_array(session()->get('role'), ['admin', 'panitia'])) {
            return redirect()->back()->with('error', 'Akses ditolak. Hanya admin dan panitia yang dapat menambah pengumuman.');
        }
        
        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|max_length[255]',
            'content' => 'required',
            'date' => 'required|valid_date',
            'sender' => 'required|max_length[100]',
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return view('admin/announcement/form', [
                'title' => 'Tambah Pengumuman',
                'validation' => $validation,
                'announcement' => [
                    'title' => $this->request->getPost('title'),
                    'content' => $this->request->getPost('content'),
                    'date' => $this->request->getPost('date'),
                    'sender' => $this->request->getPost('sender'),
                ]
            ]);
        }
        
        // Save announcement
        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'date' => $this->request->getPost('date') . ' ' . date('H:i:s'),
            'sender' => $this->request->getPost('sender'),
        ];
        
        $this->announcementModel->save($data);
        
        return redirect()->to('/announcement')->with('success', 'Pengumuman berhasil ditambahkan.');
    }
    
    /**
     * Show form to edit announcement (admin/panitia only)
     *
     * @param int $id
     * @return string
     */
    public function edit($id)
    {
        // Check if user has admin or panitia role
        if (!in_array(session()->get('role'), ['admin', 'panitia'])) {
            return redirect()->back()->with('error', 'Akses ditolak. Hanya admin dan panitia yang dapat mengedit pengumuman.');
        }
        
        $announcement = $this->announcementModel->getById($id);
        
        if (!$announcement) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengumuman tidak ditemukan');
        }
        
        return view('admin/announcement/form', [
            'title' => 'Edit Pengumuman',
            'announcement' => $announcement,
            'validation' => \Config\Services::validation()
        ]);
    }
    
    /**
     * Update announcement (admin/panitia only)
     *
     * @param int $id
     * @return mixed
     */
    public function update($id)
    {
        // Check if user has admin or panitia role
        if (!in_array(session()->get('role'), ['admin', 'panitia'])) {
            return redirect()->back()->with('error', 'Akses ditolak. Hanya admin dan panitia yang dapat mengedit pengumuman.');
        }
        
        $announcement = $this->announcementModel->getById($id);
        
        if (!$announcement) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengumuman tidak ditemukan');
        }
        
        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|max_length[255]',
            'content' => 'required',
            'date' => 'required|valid_date',
            'sender' => 'required|max_length[100]',
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return view('admin/announcement/form', [
                'title' => 'Edit Pengumuman',
                'validation' => $validation,
                'announcement' => array_merge($announcement, [
                    'title' => $this->request->getPost('title'),
                    'content' => $this->request->getPost('content'),
                    'date' => $this->request->getPost('date'),
                    'sender' => $this->request->getPost('sender'),
                ])
            ]);
        }
        
        // Update announcement
        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'date' => $this->request->getPost('date') . ' ' . date('H:i:s'),
            'sender' => $this->request->getPost('sender'),
        ];
        
        $this->announcementModel->update($id, $data);
        
        return redirect()->to('/announcement')->with('success', 'Pengumuman berhasil diperbarui.');
    }
    
    /**
     * Delete announcement (admin/panitia only)
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        // Check if user has admin or panitia role
        if (!in_array(session()->get('role'), ['admin', 'panitia'])) {
            return redirect()->back()->with('error', 'Akses ditolak. Hanya admin dan panitia yang dapat menghapus pengumuman.');
        }
        
        $announcement = $this->announcementModel->getById($id);
        
        if (!$announcement) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengumuman tidak ditemukan');
        }
        
        $this->announcementModel->delete($id);
        
        return redirect()->to('/announcement')->with('success', 'Pengumuman berhasil dihapus.');
    }
}