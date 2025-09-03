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
        
        // If user is student, try to get student data
        $student = null;
        $submission = null;
        
        if ($role === 'siswa') {
            $student = $this->studentModel->where('user_id', session()->get('user_id'))->first();
            
            if ($student) {
                $submission = $this->submissionModel->where('student_id', $student['id'])->first();
            }
        }

        $data = [
            'title' => 'Dashboard',
            'role' => $role,
            'student' => $student,
            'submission' => $submission
        ];

        return view('user/dashboard', $data);
    }
}