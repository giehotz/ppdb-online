<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\StudentModel;

class PanitiaController extends BaseController
{
    protected $documentModel;
    protected $studentModel;

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
        $this->studentModel = new StudentModel();
    }

    public function documents()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        // Get all documents with student information
        $documents = $this->documentModel
            ->select('documents.*, students.full_name as student_name')
            ->join('students', 'documents.student_id = students.id')
            ->findAll();

        // Document types
        $documentTypes = [
            'birth_certificate' => 'Akte Kelahiran',
            'family_card' => 'Kartu Keluarga',
            'photo' => 'Pas Foto',
            'rapor' => 'Rapor',
            'kip' => 'KIP',
            'other' => 'Dokumen Lainnya'
        ];

        // Status labels
        $statusLabels = [
            'uploaded' => 'Belum Diverifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak'
        ];

        $data = [
            'title' => 'Verifikasi Dokumen',
            'documents' => $documents,
            'documentTypes' => $documentTypes,
            'statusLabels' => $statusLabels
        ];

        return view('panitia/documents', $data);
    }

    public function verifyDocument()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $documentId = $this->request->getPost('document_id');
        $status = $this->request->getPost('status');
        $notes = $this->request->getPost('notes');

        // Validate input
        if (!$documentId || !in_array($status, ['verified', 'rejected'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak valid']);
        }

        // Get document
        $document = $this->documentModel->find($documentId);
        
        if (!$document) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Dokumen tidak ditemukan']);
        }

        // Update document
        $data = [
            'id' => $documentId,
            'status' => $status,
            'verified_by' => session()->get('user_id'),
            'verified_at' => date('Y-m-d H:i:s')
        ];

        // Add notes if provided and status is rejected
        if ($status === 'rejected' && !empty($notes)) {
            $data['notes'] = $notes;
        }

        if ($this->documentModel->save($data)) {
            $statusLabels = [
                'verified' => 'Terverifikasi',
                'rejected' => 'Ditolak'
            ];
            
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Dokumen berhasil ' . strtolower($statusLabels[$status])
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui dokumen']);
        }
    }

    public function documentDetail($documentId)
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        // Get document with student information
        $document = $this->documentModel
            ->select('documents.*, students.full_name as student_name')
            ->join('students', 'documents.student_id = students.id')
            ->where('documents.id', $documentId)
            ->first();

        if (!$document) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Document types
        $documentTypes = [
            'birth_certificate' => 'Akte Kelahiran',
            'family_card' => 'Kartu Keluarga',
            'photo' => 'Pas Foto',
            'rapor' => 'Rapor',
            'kip' => 'KIP',
            'other' => 'Dokumen Lainnya'
        ];

        // Status labels
        $statusLabels = [
            'uploaded' => 'Belum Diverifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak'
        ];

        $data = [
            'title' => 'Detail Dokumen',
            'document' => $document,
            'documentTypes' => $documentTypes,
            'statusLabels' => $statusLabels
        ];

        return view('panitia/document_detail', $data);
    }
}