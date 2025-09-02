<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MadrasahProfileModel;
use App\Models\AcademicYearModel;
use App\Models\StudentModel;
use App\Models\SubmissionModel;
use App\Models\DocumentModel;

class AdminController extends BaseController
{
    protected $userModel;
    protected $madrasahProfileModel;
    protected $academicYearModel;
    protected $studentModel;
    protected $submissionModel;
    protected $documentModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->madrasahProfileModel = new MadrasahProfileModel();
        $this->academicYearModel = new AcademicYearModel();
        $this->studentModel = new StudentModel();
        $this->submissionModel = new SubmissionModel();
        $this->documentModel = new DocumentModel();
    }
    
    public function dashboard()
    {
        // Check if user is logged in and has admin role
        if (!session()->has('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }
        
        // Get user statistics
        $userCount = $this->userModel->countAll();
        $studentCount = $this->userModel->where('role', 'siswa')->countAllResults();
        $committeeCount = $this->userModel->where('role', 'panitia')->countAllResults();
        $adminCount = $this->userModel->where('role', 'admin')->countAllResults();
        
        // Get student statistics
        $submissionCount = $this->submissionModel->countAll();
        $acceptedCount = $this->submissionModel->where('status', 'diterima')->countAllResults();
        $verifiedCount = $this->submissionModel->where('status', 'terverifikasi')->countAllResults();
        $waitingVerificationCount = $this->submissionModel->where('status', 'menunggu_verifikasi')->countAllResults();
        $rejectedCount = $this->submissionModel->where('status', 'ditolak')->countAllResults();
        $reservedCount = $this->submissionModel->where('status', 'cadangan')->countAllResults();
        
        // Get document statistics
        $documentCount = $this->documentModel->countAll();
        $verifiedDocumentCount = $this->documentModel->where('status', 'verified')->countAllResults();
        $unverifiedDocumentCount = $this->documentModel->where('status', 'uploaded')->countAllResults();
        $rejectedDocumentCount = $this->documentModel->where('status', 'rejected')->countAllResults();
        
        // Get madrasah profile
        $madrasahProfile = $this->madrasahProfileModel->first();
        
        // Get active academic year
        $activeAcademicYear = $this->academicYearModel->getActive();
        
        $data = [
            'title' => 'Admin Dashboard',
            'user' => [
                'username' => session()->get('username'),
                'email' => session()->get('email'),
                'role' => session()->get('role'),
            ],
            'userCount' => $userCount,
            'studentCount' => $studentCount,
            'committeeCount' => $committeeCount,
            'adminCount' => $adminCount,
            'submissionCount' => $submissionCount,
            'acceptedCount' => $acceptedCount,
            'verifiedCount' => $verifiedCount,
            'waitingVerificationCount' => $waitingVerificationCount,
            'rejectedCount' => $rejectedCount,
            'reservedCount' => $reservedCount,
            'documentCount' => $documentCount,
            'verifiedDocumentCount' => $verifiedDocumentCount,
            'unverifiedDocumentCount' => $unverifiedDocumentCount,
            'rejectedDocumentCount' => $rejectedDocumentCount,
            'madrasahProfile' => $madrasahProfile,
            'activeAcademicYear' => $activeAcademicYear,
            'recentActivities' => [] // Placeholder for future implementation
        ];

        return view('admin/dashboard', $data);
    }
}