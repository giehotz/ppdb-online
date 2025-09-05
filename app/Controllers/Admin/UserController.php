<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Menampilkan daftar user
     */
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

    /**
     * Menampilkan form tambah user
     */
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

    /**
     * Menyimpan user baru
     */
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
            'role' => 'required|in_list[admin,siswa,panitia,kepala_sekolah]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Tentukan password default berdasarkan role
        $role = $this->request->getPost('role');
        $defaultPassword = $this->getDefaultPassword($role);
        $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password_hash' => $hashedPassword,
            'role' => $role,
            'first_login' => 1 // Set first login ke 1 agar user harus ganti password saat login pertama
        ];

        if ($this->userModel->save($data)) {
            session()->setFlashdata('success', 'User berhasil ditambahkan dengan password default: ' . $defaultPassword);
            return redirect()->to('/admin/users');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan user');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Menampilkan form edit user
     */
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

    /**
     * Memperbarui data user
     */
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

        // Hanya validasi password jika diisi
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[8]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'id' => $id,
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role')
        ];

        // Hanya update password jika diisi
        if (!empty($password)) {
            $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
            // Jika admin mengganti password, set first_login ke 1 agar user harus ganti password saat login berikutnya
            $data['first_login'] = 1;
        }

        if ($this->userModel->save($data)) {
            session()->setFlashdata('success', 'User berhasil diupdate');
            return redirect()->to('/admin/users');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate user');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Menghapus user
     */
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

        // Cegah user menghapus akun sendiri
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

    /**
     * Reset password user
     */
    public function resetPassword($id)
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

        // Tentukan password default berdasarkan role
        $defaultPassword = $this->getDefaultPassword($user['role']);
        $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

        $data = [
            'id' => $id,
            'password_hash' => $hashedPassword,
            'first_login' => 1 // Set first login ke 1 agar user harus ganti password saat login pertama
        ];

        if ($this->userModel->save($data)) {
            session()->setFlashdata('success', 'Password user berhasil direset menjadi: ' . $defaultPassword);
        } else {
            session()->setFlashdata('error', 'Gagal mereset password user');
        }

        return redirect()->to('/admin/users');
    }

    /**
     * Mendapatkan password default berdasarkan role
     */
    private function getDefaultPassword($role)
    {
        switch ($role) {
            case 'siswa':
                return 'siswa123';
            case 'panitia':
                return 'panitia123';
            case 'admin':
                return 'admin123';
            case 'kepala_sekolah':
                return 'kepsek123';
            default:
                return 'default123';
        }
    }
}