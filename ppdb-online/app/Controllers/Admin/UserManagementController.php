<?php

namespace App\Controllers\Admin;

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
        // Check if user is logged in and has admin role
        if (!session()->has('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->findAll()
        ];
        
        return view('admin/users/index', $data);
    }
    
    public function create()
    {
        // Check if user is logged in and has admin role
        if (!session()->has('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Tambah User'
        ];
        
        return view('admin/users/create', $data);
    }
    
    public function store()
    {
        // Check if user is logged in and has admin role
        if (!session()->has('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[100]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
            'role' => 'required|in_list[admin,siswa,panitia,kepala_sekolah]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role')
        ];
        
        if ($this->userModel->save($data)) {
            session()->setFlashdata('success', 'User berhasil ditambahkan');
            return redirect()->to('/admin/users');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan user');
            return redirect()->back()->withInput();
        }
    }
    
    public function edit($id)
    {
        // Check if user is logged in and has admin role
        if (!session()->has('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }
        
        $user = $this->userModel->find($id);
        
        if (!$user) {
            session()->setFlashdata('error', 'User tidak ditemukan');
            return redirect()->to('/admin/users');
        }
        
        $data = [
            'title' => 'Edit User',
            'user' => $user
        ];
        
        return view('admin/users/edit', $data);
    }
    
    public function update($id)
    {
        // Check if user is logged in and has admin role
        if (!session()->has('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }
        
        $user = $this->userModel->find($id);
        
        if (!$user) {
            session()->setFlashdata('error', 'User tidak ditemukan');
            return redirect()->to('/admin/users');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[100]|is_unique[users.username,id,' . $id . ']',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
            'role' => 'required|in_list[admin,siswa,panitia,kepala_sekolah]'
        ];
        
        // Only validate password if it's being changed
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[8]';
            $rules['password_confirm'] = 'matches[password]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role')
        ];
        
        // Only update password if it's being changed
        if (!empty($password)) {
            $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        if ($this->userModel->update($id, $data)) {
            session()->setFlashdata('success', 'User berhasil diupdate');
            return redirect()->to('/admin/users');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate user');
            return redirect()->back()->withInput();
        }
    }
    
    public function delete($id)
    {
        // Check if user is logged in and has admin role
        if (!session()->has('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }
        
        $user = $this->userModel->find($id);
        
        if (!$user) {
            session()->setFlashdata('error', 'User tidak ditemukan');
            return redirect()->to('/admin/users');
        }
        
        // Prevent user from deleting themselves
        if ($id == session()->get('user_id')) {
            session()->setFlashdata('error', 'Anda tidak bisa menghapus akun sendiri');
            return redirect()->to('/admin/users');
        }
        
        if ($this->userModel->delete($id)) {
            session()->setFlashdata('success', 'User berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus user');
        }
        
        return redirect()->to('/admin/users');
    }
}