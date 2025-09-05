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
            } else if ($role === 'siswa') {
                return redirect()->to('/student/dashboard');
            } else if ($role === 'kepala_sekolah') {
                return redirect()->to('/kepala-sekolah/dashboard');
            } else {
                return redirect()->to('/student/dashboard');
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
        // Perbaiki: Gunakan 'email' sesuai dengan nama field di form
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        log_message('debug', 'Login attempt for email: ' . $email);

        // Cari user berdasarkan username atau email
        $user = $this->userModel
            ->where('username', $email)
            ->orWhere('email', $email)
            ->first();

        // Jika user tidak ditemukan
        if (!$user) {
            log_message('debug', 'User not found for email: ' . $email);
            session()->setFlashdata('error', 'Email atau password salah');
            return redirect()->back()->withInput();
        }

        log_message('debug', 'User found: ' . $user['username'] . ' with role: ' . $user['role']);
        log_message('debug', 'Password hash length: ' . strlen($user['password_hash']));

        // Verifikasi password dengan fallback untuk hash lama (MD5)
        $passwordValid = false;
        $needsRehash = false;
        
        // Cek apakah password_hash adalah MD5 lama (panjang 32 karakter)
        if (strlen($user['password_hash']) === 32) {
            log_message('debug', 'Password hash is MD5 (32 chars)');
            // Verifikasi dengan MD5
            if (md5($password) === $user['password_hash']) {
                $passwordValid = true;
                $needsRehash = true; // Perlu di-rehash ke bcrypt
                log_message('debug', 'MD5 password verified successfully');
            } else {
                log_message('debug', 'MD5 password verification failed');
            }
        } else {
            log_message('debug', 'Password hash is bcrypt ('. strlen($user['password_hash']) .' chars)');
            // Verifikasi dengan password_verify (bcrypt)
            if (password_verify($password, $user['password_hash'])) {
                $passwordValid = true;
                log_message('debug', 'Bcrypt password verified successfully');

                // Cek apakah perlu di-rehash (jika algoritma password berubah)
                if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
                    $needsRehash = true;
                    log_message('debug', 'Password needs rehash');
                }
            } else {
                log_message('debug', 'Bcrypt password verification failed');
            }
        }

        // Jika password tidak valid
        if (!$passwordValid) {
            log_message('debug', 'Password validation failed for user: ' . $email);
            session()->setFlashdata('error', 'Email atau password salah');
            return redirect()->back()->withInput();
        }

        log_message('debug', 'Password validated successfully for user: ' . $email);

        // Jika password valid tapi perlu di-rehash, update hash di database
        if ($needsRehash) {
            log_message('debug', 'Rehashing password for user: ' . $email);
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $this->userModel->update($user['id'], ['password_hash' => $newHash]);
            
            // Update user array dengan hash baru untuk session
            $user['password_hash'] = $newHash;
        }

        // Set session
        $sessionData = [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'],
            'logged_in' => true
        ];

        session()->set($sessionData);
        log_message('debug', 'Session set for user: ' . $email . ' with role: ' . $user['role']);

        // Cek apakah user perlu mengganti password saat login pertama
        if ($user['first_login'] == 1) {
            log_message('debug', 'Redirecting to force change password for user: ' . $email);
            return redirect()->to('/auth/force-change-password');
        }

        // Redirect ke dashboard sesuai role
        log_message('debug', 'Redirecting to dashboard for user: ' . $email);
        return redirect()->to("/{$user['role']}/dashboard");
    }
    
    /**
     * Menampilkan halaman force change password
     */
    public function forceChangePassword()
    {
        // Pastikan hanya user dengan first_login = 1 yang bisa mengakses
        if (!session()->has('logged_in') || session()->get('first_login') != 1) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Ganti Password'
        ];

        return view('auth/force_change_password', $data);
    }

    /**
     * Memproses force change password
     */
    public function processForceChangePassword()
    {
        // Pastikan hanya user dengan first_login = 1 yang bisa mengakses
        if (!session()->has('logged_in') || session()->get('first_login') != 1) {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userId = session()->get('user_id');
        $password = $this->request->getPost('password');

        // Update password dan set first_login ke 0
        $data = [
            'id' => $userId,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'first_login' => 0
        ];

        if ($this->userModel->save($data)) {
            // Update session
            session()->set('first_login', 0);
            session()->setFlashdata('success', 'Password berhasil diubah');
            
            // Redirect ke dashboard sesuai role
            $role = session()->get('role');
            return redirect()->to("/{$role}/dashboard");
        } else {
            session()->setFlashdata('error', 'Gagal mengubah password');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    /**
     * Menampilkan halaman register
     */
    public function register()
    {
        // Jika user sudah login, redirect ke dashboard
        if (session()->has('logged_in')) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Register'
        ];

        return view('auth/register', $data);
    }

    /**
     * Memproses register
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
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'siswa', // Default role untuk register
            'first_login' => 1
        ];

        if ($this->userModel->save($data)) {
            session()->setFlashdata('success', 'Registrasi berhasil. Silakan login.');
            return redirect()->to('/login');
        } else {
            session()->setFlashdata('error', 'Gagal melakukan registrasi');
            return redirect()->back()->withInput();
        }
    }
}