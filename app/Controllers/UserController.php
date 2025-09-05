<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\SubmissionModel;

class UserController extends BaseController
{
    protected $studentModel;
    protected $submissionModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->submissionModel = new SubmissionModel();
    }

    public function dashboard()
    {
        // Ensure user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        // Get user role
        $role = session()->get('role');
        
        // For non-student users, get their data
        $student = null;
        $submission = null;

        $data = [
            'title' => 'Dashboard',
            'role' => $role,
            'student' => $student,
            'submission' => $submission
        ];

        return view('student/user_dashboard', $data);
    }
}