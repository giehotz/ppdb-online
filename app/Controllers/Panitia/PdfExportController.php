<?php

namespace App\Controllers\Panitia;

use App\Controllers\BaseController;
use App\Models\SubmissionModel;
use App\Models\StudentModel;
use App\Models\ParentModel;
use App\Models\AddressModel;
use App\Models\PriorSchoolModel;
use App\Models\DocumentModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfExportController extends BaseController
{
    protected $submissionModel;
    protected $studentModel;
    protected $parentModel;
    protected $addressModel;
    protected $priorSchoolModel;
    protected $documentModel;

    public function __construct()
    {
        $this->submissionModel = new SubmissionModel();
        $this->studentModel = new StudentModel();
        $this->parentModel = new ParentModel();
        $this->addressModel = new AddressModel();
        $this->priorSchoolModel = new PriorSchoolModel();
        $this->documentModel = new DocumentModel();
    }

    public function studentRegistrationForm($submissionId)
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        // Get submission with student information
        $submission = $this->submissionModel
            ->select('submissions.*, students.*, users.username')
            ->join('students', 'submissions.student_id = students.id')
            ->join('users', 'students.user_id = users.id', 'left')
            ->where('submissions.id', $submissionId)
            ->first();

        if (!$submission) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get student's parents
        $parents = $this->parentModel
            ->where('student_id', $submission['student_id'])
            ->findAll();

        // Get student's addresses
        $addresses = $this->addressModel
            ->where('student_id', $submission['student_id'])
            ->findAll();

        // Get student's prior school
        $priorSchool = $this->priorSchoolModel
            ->where('student_id', $submission['student_id'])
            ->first();

        // Get student's photo
        $photo = $this->documentModel
            ->where('student_id', $submission['student_id'])
            ->where('document_type', 'photo')
            ->first();

        // Prepare data for the view
        $data = [
            'submission' => $submission,
            'parents' => $parents,
            'addresses' => $addresses,
            'priorSchool' => $priorSchool,
            'photo' => $photo
        ];

        // Load the view and convert to PDF
        $html = view('panitia/pdf/registration_form', $data);

        // Configure Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output the PDF
        $filename = 'Formulir_Pendaftaran_' . $submission['registration_no'] . '.pdf';
        $dompdf->stream($filename, ['Attachment' => true]);
    }

    public function studentRegistrationReceipt($submissionId)
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        // Get submission with student information
        $submission = $this->submissionModel
            ->select('submissions.*, students.full_name, students.nisn, students.nik, students.birth_place, students.birth_date, students.gender')
            ->join('students', 'submissions.student_id = students.id')
            ->where('submissions.id', $submissionId)
            ->first();

        if (!$submission) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Prepare data for the view
        $data = [
            'submission' => $submission,
            'currentDate' => date('Y-m-d')
        ];

        // Load the view and convert to PDF
        $html = view('panitia/pdf/registration_receipt', $data);

        // Configure Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output the PDF
        $filename = 'Bukti_Pendaftaran_' . $submission['registration_no'] . '.pdf';
        $dompdf->stream($filename, ['Attachment' => true]);
    }
}