<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubmissionModel;
use App\Models\StudentModel;
use App\Models\DocumentModel;
use App\Models\UserModel;

class ReportController extends BaseController
{
    protected $submissionModel;
    protected $studentModel;
    protected $documentModel;
    protected $userModel;

    public function __construct()
    {
        $this->submissionModel = new SubmissionModel();
        $this->studentModel = new StudentModel();
        $this->documentModel = new DocumentModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Ensure user is logged in and has admin role
        if (!session()->has('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Get statistics
        $totalSubmissions = $this->submissionModel->countAll();
        $totalStudents = $this->userModel->where('role', 'siswa')->countAllResults();
        $totalDocuments = $this->documentModel->countAll();
        
        // Get submission status statistics
        $submissionStats = [
            'menunggu_verifikasi' => $this->submissionModel->where('status', 'menunggu_verifikasi')->countAllResults(),
            'terverifikasi' => $this->submissionModel->where('status', 'terverifikasi')->countAllResults(),
            'diterima' => $this->submissionModel->where('status', 'diterima')->countAllResults(),
            'cadangan' => $this->submissionModel->where('status', 'cadangan')->countAllResults(),
            'ditolak' => $this->submissionModel->where('status', 'ditolak')->countAllResults()
        ];
        
        // Get document status statistics
        $documentStats = [
            'uploaded' => $this->documentModel->where('status', 'uploaded')->countAllResults(),
            'verified' => $this->documentModel->where('status', 'verified')->countAllResults(),
            'rejected' => $this->documentModel->where('status', 'rejected')->countAllResults()
        ];

        $data = [
            'title' => 'Laporan',
            'totalSubmissions' => $totalSubmissions,
            'totalStudents' => $totalStudents,
            'totalDocuments' => $totalDocuments,
            'submissionStats' => $submissionStats,
            'documentStats' => $documentStats
        ];

        return view('admin/reports/index', $data);
    }
}