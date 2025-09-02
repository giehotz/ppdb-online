<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Menampilkan halaman login
     */
    public function login()
    {
        // Jika pengguna sudah login, redirect ke dashboard sesuai role
        if (session()->has('logged_in')) {
            $role = session()->get('role');
            if ($role === 'panitia') {
                return redirect()->to('/panitia/dashboard');
            } else if ($role === 'admin') {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/user/dashboard');
            }
        }

        $data = [
            'title' => 'Login',
        ];

        return view('auth/login', $data);
    }

    /**
     * Memproses login pengguna
     */
    public function attemptLogin()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ];
        
        if (!$this->validate($rules)) {
            return view('auth/login', [
                'title' => 'Login',
                'validation' => $this->validator
            ]);
        }
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        // Cari pengguna berdasarkan email
        $user = $this->userModel->where('email', $email)->first();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Set session
            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'],
                'logged_in' => TRUE
            ];
            
            session()->set($sessionData);
            
            // Redirect berdasarkan role
            if ($user['role'] === 'panitia') {
                return redirect()->to('/panitia/dashboard');
            } else if ($user['role'] === 'admin') {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/user/dashboard');
            }
        } else {
            session()->setFlashdata('error', 'Email atau password salah');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Menampilkan halaman registrasi
     */
    public function register()
    {
        $data = [
            'title' => 'Register',
        ];

        return view('auth/register', $data);
    }

    /**
     * Memproses registrasi pengguna baru
     */
    public function attemptRegister()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[100]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]'
        ];
        
        if (!$this->validate($rules)) {
            return view('auth/register', [
                'title' => 'Register',
                'validation' => $this->validator
            ]);
        }
        
        // Simpan pengguna baru
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'siswa' // Default role untuk pengguna baru
        ];
        
        if ($this->userModel->save($data)) {
            session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
            return redirect()->to('/login');
        } else {
            session()->setFlashdata('error', 'Registrasi gagal. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Logout pengguna
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}