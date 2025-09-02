<?php

namespace App\Controllers;

use App\Models\SubmissionModel;
use App\Models\StudentModel;
use App\Models\NotificationModel;
use App\Models\UserModel;

class PanitiaRegistrationController extends BaseController
{
    protected $submissionModel;
    protected $studentModel;
    protected $notificationModel;
    protected $userModel;

    public function __construct()
    {
        $this->submissionModel = new SubmissionModel();
        $this->studentModel = new StudentModel();
        $this->notificationModel = new NotificationModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
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

        return view('panitia/registrations', $data);
    }

    public function updateStatus()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $submissionId = $this->request->getPost('submission_id');
        $status = $this->request->getPost('status');
        $rejectionReason = $this->request->getPost('rejection_reason');

        // Validate input
        if (!$submissionId || !in_array($status, ['menunggu_verifikasi', 'terverifikasi', 'diterima', 'cadangan', 'ditolak'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak valid']);
        }

        // If status is 'ditolak', rejection reason is required
        if ($status === 'ditolak' && empty($rejectionReason)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Alasan penolakan harus diisi']);
        }

        // Get submission with student information
        $submission = $this->submissionModel
            ->select('submissions.*, students.full_name as student_name, students.user_id')
            ->join('students', 'submissions.student_id = students.id')
            ->where('submissions.id', $submissionId)
            ->first();
        
        if (!$submission) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data pendaftaran tidak ditemukan']);
        }

        // Update submission
        $data = [
            'id' => $submissionId,
            'status' => $status,
            'verified_by' => session()->get('user_id'),
        ];

        // Add rejection reason if provided and status is ditolak
        if ($status === 'ditolak' && !empty($rejectionReason)) {
            $data['rejection_reason'] = $rejectionReason;
        }

        if ($this->submissionModel->save($data)) {
            // Create notification for the student
            $this->createStatusNotification($submission, $status, $rejectionReason);
            
            $statusLabels = [
                'menunggu_verifikasi' => 'Menunggu Verifikasi',
                'terverifikasi' => 'Terverifikasi',
                'diterima' => 'Diterima',
                'cadangan' => 'Cadangan',
                'ditolak' => 'Ditolak'
            ];
            
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Status pendaftaran berhasil diubah menjadi ' . strtolower($statusLabels[$status])
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui status pendaftaran']);
        }
    }

    public function detail($submissionId)
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        // Get submission with student information
        $submission = $this->submissionModel
            ->select('submissions.*, students.full_name as student_name, students.nisn, students.nik, students.birth_date')
            ->join('students', 'submissions.student_id = students.id')
            ->where('submissions.id', $submissionId)
            ->first();

        if (!$submission) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

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
            'title' => 'Detail Pendaftaran',
            'submission' => $submission,
            'statusLabels' => $statusLabels,
            'statusColors' => $statusColors
        ];

        return view('panitia/registration_detail', $data);
    }
    
    /**
     * Create a notification when registration status is updated
     * 
     * @param array $submission
     * @param string $status
     * @param string|null $rejectionReason
     * @return void
     */
    private function createStatusNotification($submission, $status, $rejectionReason = null)
    {
        // Only create notification if student has a user account
        if (empty($submission['user_id'])) {
            return;
        }
        
        $title = '';
        $message = '';
        $registrationNo = $submission['registration_no'];
        
        switch ($status) {
            case 'terverifikasi':
                $title = 'Status Pendaftaran Diperbarui';
                $message = "Kabar baik! Dokumen dan data pendaftaran Anda dengan nomor {$registrationNo} telah berhasil diverifikasi oleh panitia.";
                break;
                
            case 'diterima':
                $title = 'Selamat! Anda Diterima';
                $message = "Selamat! Anda dinyatakan Diterima sebagai siswa baru di MIN 2 Tanggamus.";
                break;
                
            case 'ditolak':
                $title = 'Pendaftaran Ditolak';
                $message = "Mohon maaf, pendaftaran Anda ditolak. Silakan cek dasbor Anda untuk melihat alasan penolakan.";
                break;
                
            case 'cadangan':
                $title = 'Status Pendaftaran Diperbarui';
                $message = "Pendaftaran Anda dengan nomor {$registrationNo} telah ditempatkan dalam daftar cadangan.";
                break;
                
            default:
                // For other statuses, we might not need to send notifications
                return;
        }
        
        // Create notification
        $notificationData = [
            'user_id' => $submission['user_id'],
            'title' => $title,
            'message' => $message,
        ];
        
        $this->notificationModel->insert($notificationData);
        
        // TODO: Implement email notification
        // For now, we'll just create the database notification
    }
}