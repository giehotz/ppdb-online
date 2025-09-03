<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DocumentModel;
use App\Models\StudentModel;

class DocumentController extends BaseController
{
    protected $documentModel;
    protected $studentModel;

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
        $this->studentModel = new StudentModel();
    }

    public function index()
    {
        // Ensure user is logged in and has admin role
        if (!session()->has('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Get all documents with student information
        $documents = $this->documentModel
            ->select('documents.*, students.full_name as student_name')
            ->join('students', 'documents.student_id = students.id')
            ->findAll();

        $documentTypes = [
            'birth_certificate' => 'Akte Kelahiran',
            'family_card' => 'Kartu Keluarga',
            'photo' => 'Pas Foto',
            'rapor' => 'Rapor',
            'kip' => 'KIP',
            'other' => 'Dokumen Lain'
        ];

        $statusLabels = [
            'uploaded' => 'Diunggah',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak'
        ];

        $data = [
            'title' => 'Manajemen Dokumen',
            'documents' => $documents,
            'documentTypes' => $documentTypes,
            'statusLabels' => $statusLabels
        ];

        return view('admin/documents/index', $data);
    }
}