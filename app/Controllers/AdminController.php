<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function dashboard()
    {
        // Check if user is logged in and has admin role
        if (!session()->has('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }
        
        // Get user statistics
        $totalUsers = $this->userModel->countAll();
        $totalStudents = $this->userModel->where('role', 'siswa')->countAllResults();
        $totalCommittee = $this->userModel->where('role', 'panitia')->countAllResults();
        $totalAdmins = $this->userModel->where('role', 'admin')->countAllResults();
        
        $data = [
            'title' => 'Admin Dashboard',
            'user' => [
                'username' => session()->get('username'),
                'email' => session()->get('email'),
                'role' => session()->get('role'),
            ],
            'totalUsers' => $totalUsers,
            'totalStudents' => $totalStudents,
            'totalCommittee' => $totalCommittee,
            'totalAdmins' => $totalAdmins
        ];

        return view('admin/dashboard', $data);
    }
}