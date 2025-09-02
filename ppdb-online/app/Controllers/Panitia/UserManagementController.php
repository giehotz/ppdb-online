<?php

namespace App\Controllers\Panitia;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserManagementController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        $search = $this->request->getGet('search');
        $role = $this->request->getGet('role');

        $builder = $this->userModel;
        
        if ($search) {
            $builder = $builder->like('username', $search)->orLike('email', $search);
        }
        
        if ($role && $role !== 'all') {
            $builder = $builder->where('role', $role);
        }

        $users = $builder->orderBy('created_at', 'DESC')->paginate(10, 'users');
        $pager = $this->userModel->pager;

        $data = [
            'title' => 'Manajemen Pengguna',
            'users' => $users,
            'pager' => $pager,
            'search' => $search,
            'role' => $role
        ];

        return view('panitia/user_management', $data);
    }

    public function create()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        return view('panitia/user_create', ['title' => 'Tambah Pengguna']);
    }

    public function store()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            'role' => 'required|in_list[admin,panitia,kepala_sekolah,siswa]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->userModel->save($userData)) {
            return redirect()->to('/panitia/users')->with('success', 'Pengguna berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan pengguna.');
        }
    }

    public function edit($id)
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('panitia/user_edit', [
            'title' => 'Edit Pengguna',
            'user' => $user
        ]);
    }

    public function update($id)
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $validation = \Config\Services::validation();
        
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'role' => 'required|in_list[admin,panitia,kepala_sekolah,siswa]'
        ];

        // Check if username has changed
        if ($user['username'] !== $this->request->getPost('username')) {
            $rules['username'] .= '|is_unique[users.username]';
        }

        // Check if email has changed
        if ($user['email'] !== $this->request->getPost('email')) {
            $rules['email'] .= '|is_unique[users.email]';
        }

        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userData = [
            'id' => $id,
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Only update password if provided
        if ($this->request->getPost('password') && !empty($this->request->getPost('password'))) {
            if ($this->request->getPost('password') !== $this->request->getPost('password_confirm')) {
                return redirect()->back()->withInput()->with('error', 'Konfirmasi password tidak cocok.');
            }
            
            $userData['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($this->userModel->save($userData)) {
            return redirect()->to('/panitia/users')->with('success', 'Pengguna berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pengguna.');
        }
    }

    public function delete($id)
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Soft delete by setting deleted_at
        $userData = [
            'id' => $id,
            'deleted_at' => date('Y-m-d H:i:s')
        ];

        if ($this->userModel->save($userData)) {
            return redirect()->to('/panitia/users')->with('success', 'Pengguna berhasil dihapus.');
        } else {
            return redirect()->to('/panitia/users')->with('error', 'Gagal menghapus pengguna.');
        }
    }
}