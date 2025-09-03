<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use CodeIgniter\Files\File;

class DocumentController extends BaseController
{
    protected $documentModel;

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
    }

    public function index()
    {
        // Ensure user is logged in and is a student
        if (!session()->has('user_id') || session()->get('role') !== 'siswa') {
            return redirect()->to('/login');
        }

        // Get student ID from user session
        $studentId = $this->getStudentIdByUserId(session()->get('user_id'));
        
        if (!$studentId) {
            return redirect()->to('/student/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        // Get documents for this student
        $documents = $this->documentModel->where('student_id', $studentId)->findAll();

        // Document types
        $documentTypes = [
            'birth_certificate' => 'Akte Kelahiran',
            'family_card' => 'Kartu Keluarga',
            'photo' => 'Pas Foto',
            'rapor' => 'Rapor',
            'kip' => 'KIP',
            'other' => 'Dokumen Lainnya'
        ];

        // Required documents
        $requiredDocuments = [
            'birth_certificate' => 'Akte Kelahiran',
            'family_card' => 'Kartu Keluarga',
            'photo' => 'Pas Foto',
            'rapor' => 'Rapor'
        ];

        // Create a map of uploaded documents by type
        $uploadedDocuments = [];
        foreach ($documents as $document) {
            $uploadedDocuments[$document['doc_type']] = $document;
        }

        $data = [
            'title' => 'Unggah Dokumen',
            'documents' => $documents,
            'documentTypes' => $documentTypes,
            'requiredDocuments' => $requiredDocuments,
            'uploadedDocuments' => $uploadedDocuments,
            'studentId' => $studentId
        ];

        return view('student/documents', $data);
    }

    public function upload()
    {
        // Ensure user is logged in and is a student
        if (!session()->has('user_id') || session()->get('role') !== 'siswa') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $studentId = $this->getStudentIdByUserId(session()->get('user_id'));
        
        if (!$studentId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data siswa tidak ditemukan']);
        }

        $docType = $this->request->getPost('doc_type');
        $file = $this->request->getFile('file');

        // Validate file
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'File tidak valid']);
        }

        // Validate file type and size
        $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array($file->getExtension(), $allowedTypes)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tipe file tidak diizinkan. Hanya JPG, PNG, dan PDF yang diizinkan.']);
        }

        // Max file size: 2MB
        if ($file->getSize() > 2 * 1024 * 1024) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Ukuran file terlalu besar. Maksimal 2MB.']);
        }

        // Generate unique filename
        $newName = $file->getRandomName();
        
        // Upload directory
        $uploadPath = WRITEPATH . 'uploads/documents/';
        
        // Create directory if not exists
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Move file to upload directory
        if ($file->move($uploadPath, $newName)) {
            // Save to database
            $data = [
                'student_id' => $studentId,
                'doc_type' => $docType,
                'file_name' => $file->getClientName(),
                'file_path' => 'uploads/documents/' . $newName,
                'mime_type' => $file->getMimeType(),
                'size_bytes' => $file->getSize(),
                'status' => 'uploaded',
                'uploaded_by' => session()->get('user_id'),
                'uploaded_at' => date('Y-m-d H:i:s')
            ];

            if ($this->documentModel->save($data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Dokumen berhasil diunggah']);
            } else {
                // Delete the uploaded file if database save fails
                unlink($uploadPath . $newName);
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan data dokumen']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengunggah file']);
        }
    }

    public function download($documentId)
    {
        // Check if user is authorized (student or panitia)
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $document = $this->documentModel->find($documentId);
        
        if (!$document) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Check if user is owner or panitia
        $userId = session()->get('user_id');
        $userRole = session()->get('role');
        
        if ($userRole !== 'panitia' && $userRole !== 'admin') {
            $studentId = $this->getStudentIdByUserId($userId);
            if ($document['student_id'] != $studentId) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }

        $filePath = WRITEPATH . $document['file_path'];
        
        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response->download($filePath, null);
    }
    
    public function delete($documentId)
    {
        // Ensure user is logged in and is a student
        if (!session()->has('user_id') || session()->get('role') !== 'siswa') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $document = $this->documentModel->find($documentId);
        
        if (!$document) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Dokumen tidak ditemukan']);
        }

        // Check if user is owner
        $studentId = $this->getStudentIdByUserId(session()->get('user_id'));
        if ($document['student_id'] != $studentId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        // Delete file from filesystem
        $filePath = WRITEPATH . $document['file_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete from database
        if ($this->documentModel->delete($documentId)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Dokumen berhasil dihapus']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menghapus dokumen']);
        }
    }

    private function getStudentIdByUserId($userId)
    {
        // For now, we'll use a simple approach
        // In a real application, you would query the students table
        // For this example, we'll assume student ID is the same as user ID
        // This should be replaced with actual logic to get student ID from user ID
        $studentModel = new \App\Models\StudentModel();
        $student = $studentModel->where('user_id', $userId)->first();
        
        return $student ? $student['id'] : null;
    }
}