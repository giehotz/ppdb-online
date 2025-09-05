<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubmissionModel;
use App\Models\StudentModel;

class SubmissionController extends BaseController
{
    protected $submissionModel;
    protected $studentModel;

    public function __construct()
    {
        $this->submissionModel = new SubmissionModel();
        $this->studentModel = new StudentModel();
    }

    public function index()
    {
        // Ensure user is logged in and has admin role
        if (!session()->has('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Get all submissions with student information
        $submissions = $this->submissionModel
            ->select('submissions.*, students.full_name as student_name')
            ->join('students', 'submissions.student_id = students.id')
            ->findAll();

        $statusLabels = [
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'terverifikasi' => 'Terverifikasi',
            'diterima' => 'Diterima',
            'cadangan' => 'Cadangan',
            'ditolak' => 'Ditolak'
        ];

        $statusColors = [
            'menunggu_verifikasi' => 'bg-yellow-500',
            'terverifikasi' => 'bg-blue-500',
            'diterima' => 'bg-green-500',
            'cadangan' => 'bg-purple-500',
            'ditolak' => 'bg-red-500'
        ];

        $data = [
            'title' => 'Manajemen Pendaftaran',
            'submissions' => $submissions,
            'statusLabels' => $statusLabels,
            'statusColors' => $statusColors
        ];

        return view('admin/submissions/index', $data);
    }

    public function show($id)
    {
        // Ensure user is logged in and has admin role
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Get submission with student information
        $submission = $this->submissionModel
            ->select('submissions.*, students.full_name as student_name, students.nisn, students.nik, students.birth_place, students.birth_date')
            ->join('students', 'submissions.student_id = students.id')
            ->where('submissions.id', $id)
            ->first();

        // If submission not found, show 404
        if (!$submission) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Submission tidak ditemukan');
        }

        // Get related data
        $priorSchool = $this->studentModel->db->table('prior_schools')
            ->where('student_id', $submission['student_id'])
            ->get()
            ->getRowArray();

        $addresses = $this->studentModel->db->table('addresses')
            ->where('student_id', $submission['student_id'])
            ->get()
            ->getResultArray();

        $parents = $this->studentModel->db->table('parents')
            ->where('student_id', $submission['student_id'])
            ->get()
            ->getResultArray();

        $familyCard = $this->studentModel->db->table('family_cards')
            ->where('student_id', $submission['student_id'])
            ->get()
            ->getRowArray();

        $statusLabels = [
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'terverifikasi' => 'Terverifikasi',
            'diterima' => 'Diterima',
            'cadangan' => 'Cadangan',
            'ditolak' => 'Ditolak'
        ];

        $data = [
            'title' => 'Detail Pendaftaran',
            'submission' => $submission,
            'priorSchool' => $priorSchool,
            'addresses' => $addresses,
            'parents' => $parents,
            'familyCard' => $familyCard,
            'statusLabels' => $statusLabels
        ];

        return view('admin/submissions/show', $data);
    }
}