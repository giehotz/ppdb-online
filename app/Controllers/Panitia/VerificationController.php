<?php

namespace App\Controllers\Panitia;

use App\Controllers\BaseController;
use App\Models\SubmissionModel;
use App\Models\StudentModel;
use App\Models\ParentModel;
use App\Models\AddressModel;
use App\Models\PriorSchoolModel;
use App\Models\DocumentModel;
use App\Models\FamilyCardModel;

class VerificationController extends BaseController
{
    protected $submissionModel;
    protected $studentModel;
    protected $parentModel;
    protected $addressModel;
    protected $priorSchoolModel;
    protected $documentModel;
    protected $familyCardModel;

    public function __construct()
    {
        $this->submissionModel = new SubmissionModel();
        $this->studentModel = new StudentModel();
        $this->parentModel = new ParentModel();
        $this->addressModel = new AddressModel();
        $this->priorSchoolModel = new PriorSchoolModel();
        $this->documentModel = new DocumentModel();
        $this->familyCardModel = new FamilyCardModel();
    }

    public function index($submissionId)
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        // Get submission with student information
        $submission = $this->submissionModel
            ->select('submissions.*, students.full_name as student_name, students.nisn, students.nik, students.birth_date, students.birth_place, students.gender, students.class_level, students.parallel_class, students.attendance_no, students.class_rank, students.student_status, students.hobby, students.aspiration, students.siblings_count')
            ->join('students', 'submissions.student_id = students.id')
            ->where('submissions.id', $submissionId)
            ->first();

        if (!$submission) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get student's parents
        $parents = $this->parentModel
            ->where('student_id', $submission['student_id'])
            ->findAll();

        // Get student's address
        $address = $this->addressModel
            ->where('student_id', $submission['student_id'])
            ->first();

        // Get student's prior school
        $priorSchool = $this->priorSchoolModel
            ->where('student_id', $submission['student_id'])
            ->first();

        // Get student's family card
        $familyCard = $this->familyCardModel
            ->where('student_id', $submission['student_id'])
            ->first();

        // Get student's documents
        $documents = $this->documentModel
            ->where('student_id', $submission['student_id'])
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
            'title' => 'Verifikasi Data dan Dokumen',
            'submission' => $submission,
            'parents' => $parents,
            'address' => $address,
            'priorSchool' => $priorSchool,
            'familyCard' => $familyCard,
            'documents' => $documents,
            'statusLabels' => $statusLabels,
            'statusColors' => $statusColors
        ];

        return view('panitia/verification', $data);
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
            // Create notification for the student (using existing method from PanitiaRegistrationController)
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
        // Load the NotificationModel
        $notificationModel = new \App\Models\NotificationModel();
        
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
        
        $notificationModel->insert($notificationData);
    }
}