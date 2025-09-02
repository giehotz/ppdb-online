<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika tidak ada sesi login, redirect ke halaman login
        if (!session()->has('logged_in')) {
            return redirect()->to('/login');
        }

        // Jika ada argumen role yang diberikan
        if (!empty($arguments)) {
            $userRole = session()->get('role');
            $allowedRoles = $arguments;
            
            // Jika role pengguna tidak dalam daftar role yang diizinkan
            if (!in_array($userRole, $allowedRoles)) {
                // Tampilkan halaman error atau redirect ke dashboard sesuai role
                return redirect()->to('/' . $userRole . '/dashboard');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan setelah request
    }
}