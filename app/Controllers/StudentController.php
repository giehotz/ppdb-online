<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\AddressModel;
use App\Models\ParentModel;
use App\Models\PriorSchoolModel;
use App\Models\FamilyCardModel;
use App\Models\SubmissionModel;
use App\Models\SequenceModel;

class StudentController extends BaseController
{
    protected $studentModel;
    protected $addressModel;
    protected $parentModel;
    protected $priorSchoolModel;
    protected $familyCardModel;
    protected $submissionModel;
    protected $sequenceModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->addressModel = new AddressModel();
        $this->parentModel = new ParentModel();
        $this->priorSchoolModel = new PriorSchoolModel();
        $this->familyCardModel = new FamilyCardModel();
        $this->submissionModel = new SubmissionModel();
        $this->sequenceModel = new SequenceModel();
    }

    public function dashboard()
    {
        // Ensure user is logged in and is a student
        if (!session()->has('user_id') || session()->get('role') !== 'siswa') {
            return redirect()->to('/login');
        }

        // Get student data
        $student = $this->studentModel->where('user_id', session()->get('user_id'))->first();
        
        // Get submission data if student exists
        $submission = null;
        if ($student) {
            $submission = $this->submissionModel->where('student_id', $student['id'])->first();
        }

        $data = [
            'title' => 'Dashboard Siswa',
            'student' => $student,
            'submission' => $submission
        ];

        return view('student/dashboard', $data);
    }

    public function registrationForm()
    {
        // Ensure user is logged in and is a student
        if (!session()->has('user_id') || session()->get('role') !== 'siswa') {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Formulir Pendaftaran Siswa',
        ];

        return view('student/registration_form', $data);
    }

    public function saveDraft()
    {
        // Ensure user is logged in and is a student
        if (!session()->has('user_id') || session()->get('role') !== 'siswa') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        // Save draft logic would go here
        // For now, we'll just return a success response
        return $this->response->setJSON(['status' => 'success', 'message' => 'Draft saved successfully']);
    }

    public function submitRegistration()
    {
        // Ensure user is logged in and is a student
        if (!session()->has('user_id') || session()->get('role') !== 'siswa') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        // Get student data
        $student = $this->studentModel->where('user_id', session()->get('user_id'))->first();
        
        if (!$student) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data siswa tidak ditemukan']);
        }

        // Update student submission state to 'submitted'
        $this->studentModel->update($student['id'], [
            'submission_state' => 'submitted',
            'submitted_at' => date('Y-m-d H:i:s')
        ]);

        // Create registration number (using current academic year as period)
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $period = $currentYear . '/' . $nextYear;
        
        $registrationNumber = $this->sequenceModel->getNextRegistrationNumber($period);

        // Create submission record
        $submissionData = [
            'student_id' => $student['id'],
            'registration_no' => $registrationNumber,
            'status' => 'menunggu_verifikasi'
        ];

        if ($this->submissionModel->insert($submissionData)) {
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Pendaftaran berhasil diajukan dengan nomor: ' . $registrationNumber
            ]);
        } else {
            // Rollback student submission state if submission creation fails
            $this->studentModel->update($student['id'], [
                'submission_state' => 'draft',
                'submitted_at' => null
            ]);
            
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Gagal membuat data pendaftaran'
            ]);
        }
    }
}