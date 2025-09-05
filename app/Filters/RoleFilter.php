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
                // Redirect ke dashboard sesuai role pengguna
                switch ($userRole) {
                    case 'admin':
                        return redirect()->to('/admin/dashboard');
                    case 'panitia':
                        return redirect()->to('/panitia/dashboard');
                    case 'siswa':
                        return redirect()->to('/student/dashboard');
                    default:
                        return redirect()->to('/student/dashboard');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan setelah request
    }
}