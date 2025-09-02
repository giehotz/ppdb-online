<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\AddressModel;
use App\Models\ParentModel;
use App\Models\PriorSchoolModel;
use App\Models\FamilyCardModel;
use App\Models\SubmissionModel;
use App\Models\SequenceModel;
use App\Models\AcademicYearModel;

class StudentController extends BaseController
{
    protected $studentModel;
    protected $addressModel;
    protected $parentModel;
    protected $priorSchoolModel;
    protected $familyCardModel;
    protected $submissionModel;
    protected $sequenceModel;
    protected $academicYearModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->addressModel = new AddressModel();
        $this->parentModel = new ParentModel();
        $this->priorSchoolModel = new PriorSchoolModel();
        $this->familyCardModel = new FamilyCardModel();
        $this->submissionModel = new SubmissionModel();
        $this->sequenceModel = new SequenceModel();
        $this->academicYearModel = new AcademicYearModel();
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

        // Get active academic year
        $academicYear = $this->academicYearModel->getActive();
        
        // Get existing student data if available
        $student = $this->studentModel->where('user_id', session()->get('user_id'))->first();
        
        $data = [
            'title' => 'Formulir Pendaftaran Siswa',
            'student' => $student,
            'academicYear' => $academicYear
        ];

        return view('student/registration_form', $data);
    }

    public function saveDraft()
    {
        // Ensure user is logged in and is a student
        if (!session()->has('user_id') || session()->get('role') !== 'siswa') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        // Get active academic year
        $academicYear = $this->academicYearModel->getActive();
        
        // Get student data if exists
        $student = $this->studentModel->where('user_id', session()->get('user_id'))->first();
        
        // Determine which step we're saving
        $step = $this->request->getPost('step');
        
        if ($step == 'personal') {
            // Collect data from request
            $data = [
                'user_id' => session()->get('user_id'),
                'nisn' => $this->request->getPost('nisn'),
                'nik' => $this->request->getPost('nik'),
                'full_name' => $this->request->getPost('full_name'),
                'birth_place' => $this->request->getPost('birth_place'),
                'birth_date' => $this->request->getPost('birth_date'),
                'gender' => $this->request->getPost('gender'),
                'student_status' => $this->request->getPost('student_status'),
                'hobby' => $this->request->getPost('hobby'),
                'aspiration' => $this->request->getPost('aspiration'),
            ];

            // Validate data
            if (empty($data['nisn']) || empty($data['nik']) || empty($data['full_name'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap']);
            }

            // Save or update student data
            if ($student) {
                // Update existing student
                $data['id'] = $student['id'];
                $this->studentModel->save($data);
                $studentId = $student['id'];
            } else {
                // Create new student
                $studentId = $this->studentModel->insert($data);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data pribadi berhasil disimpan']);
            
        } else if ($step == 'school') {
            // Get student ID
            $studentId = $student['id'] ?? null;
            if (!$studentId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data pribadi harus diisi terlebih dahulu']);
            }

            // Collect data from request
            $data = [
                'student_id' => $studentId,
                'school_name' => $this->request->getPost('school_name'),
                'school_type' => $this->request->getPost('school_type'),
                'school_address' => $this->request->getPost('school_address'),
                'graduation_year' => $this->request->getPost('graduation_year'),
            ];

            // Validate data
            if (empty($data['school_name']) || empty($data['school_type']) || empty($data['graduation_year'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data sekolah tidak lengkap']);
            }

            // Check if prior school data already exists
            $priorSchool = $this->priorSchoolModel->where('student_id', $studentId)->first();
            
            if ($priorSchool) {
                // Update existing record
                $data['id'] = $priorSchool['id'];
                $this->priorSchoolModel->save($data);
            } else {
                // Create new record
                $this->priorSchoolModel->save($data);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data sekolah berhasil disimpan']);
            
        } else if ($step == 'address') {
            // Get student ID
            $studentId = $student['id'] ?? null;
            if (!$studentId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data pribadi harus diisi terlebih dahulu']);
            }

            // Collect KK address data from request
            $kkAddressData = [
                'student_id' => $studentId,
                'type' => 'kk',
                'street_address' => $this->request->getPost('kk_street_address'),
                'village' => $this->request->getPost('kk_village'),
                'district' => $this->request->getPost('kk_district'),
                'regency' => $this->request->getPost('kk_regency'),
                'province' => $this->request->getPost('kk_province'),
                'postal_code' => $this->request->getPost('kk_postal_code'),
            ];

            // Collect domisili address data from request
            $domisiliAddressData = [
                'student_id' => $studentId,
                'type' => 'domisili',
                'street_address' => $this->request->getPost('domisili_street_address'),
                'village' => $this->request->getPost('domisili_village'),
                'district' => $this->request->getPost('domisili_district'),
                'regency' => $this->request->getPost('domisili_regency'),
                'province' => $this->request->getPost('domisili_province'),
                'postal_code' => $this->request->getPost('domisili_postal_code'),
            ];

            // Validate data
            if (empty($kkAddressData['street_address']) || empty($kkAddressData['village'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Alamat Kartu Keluarga tidak lengkap']);
            }

            if (empty($domisiliAddressData['street_address']) || empty($domisiliAddressData['village'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Alamat domisili tidak lengkap']);
            }

            // Check if addresses already exist
            $kkAddress = $this->addressModel->where(['student_id' => $studentId, 'type' => 'kk'])->first();
            $domisiliAddress = $this->addressModel->where(['student_id' => $studentId, 'type' => 'domisili'])->first();
            
            // Save or update KK address
            if ($kkAddress) {
                $kkAddressData['id'] = $kkAddress['id'];
                $this->addressModel->save($kkAddressData);
            } else {
                $this->addressModel->save($kkAddressData);
            }

            // Save or update domisili address
            if ($domisiliAddress) {
                $domisiliAddressData['id'] = $domisiliAddress['id'];
                $this->addressModel->save($domisiliAddressData);
            } else {
                $this->addressModel->save($domisiliAddressData);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data alamat berhasil disimpan']);
            
        } else if ($step == 'parents') {
            // Get student ID
            $studentId = $student['id'] ?? null;
            if (!$studentId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data pribadi harus diisi terlebih dahulu']);
            }

            // Father data
            $fatherData = [
                'student_id' => $studentId,
                'relation' => 'father',
                'full_name' => $this->request->getPost('father_full_name'),
                'nik' => $this->request->getPost('father_nik'),
                'birth_year' => $this->request->getPost('father_birth_year'),
                'education' => $this->request->getPost('father_education'),
                'occupation' => $this->request->getPost('father_occupation'),
                'monthly_income' => $this->request->getPost('father_monthly_income'),
                'phone' => $this->request->getPost('father_phone'),
            ];

            // Mother data
            $motherData = [
                'student_id' => $studentId,
                'relation' => 'mother',
                'full_name' => $this->request->getPost('mother_full_name'),
                'nik' => $this->request->getPost('mother_nik'),
                'birth_year' => $this->request->getPost('mother_birth_year'),
                'education' => $this->request->getPost('mother_education'),
                'occupation' => $this->request->getPost('mother_occupation'),
                'monthly_income' => $this->request->getPost('mother_monthly_income'),
                'phone' => $this->request->getPost('mother_phone'),
            ];

            // Validate data
            if (empty($fatherData['full_name']) || empty($fatherData['nik'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data ayah tidak lengkap']);
            }

            if (empty($motherData['full_name']) || empty($motherData['nik'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data ibu tidak lengkap']);
            }

            // Check if parents data already exist
            $father = $this->parentModel->where(['student_id' => $studentId, 'relation' => 'father'])->first();
            $mother = $this->parentModel->where(['student_id' => $studentId, 'relation' => 'mother'])->first();
            
            // Save or update father data
            if ($father) {
                $fatherData['id'] = $father['id'];
                $this->parentModel->save($fatherData);
            } else {
                $this->parentModel->save($fatherData);
            }

            // Save or update mother data
            if ($mother) {
                $motherData['id'] = $mother['id'];
                $this->parentModel->save($motherData);
            } else {
                $this->parentModel->save($motherData);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data orang tua berhasil disimpan']);
            
        } else if ($step == 'family_card') {
            // Get student ID
            $studentId = $student['id'] ?? null;
            if (!$studentId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data pribadi harus diisi terlebih dahulu']);
            }

            // Family card data
            $familyCardData = [
                'student_id' => $studentId,
                'family_card_no' => $this->request->getPost('family_card_no'),
                'father_name' => $this->request->getPost('father_name_on_card'),
                'mother_name' => $this->request->getPost('mother_name_on_card'),
                'address' => $this->request->getPost('family_card_address'),
                'rt' => $this->request->getPost('family_card_rt'),
                'rw' => $this->request->getPost('family_card_rw'),
                'village' => $this->request->getPost('family_card_village'),
                'district' => $this->request->getPost('family_card_district'),
                'regency' => $this->request->getPost('family_card_regency'),
                'province' => $this->request->getPost('family_card_province'),
                'postal_code' => $this->request->getPost('family_card_postal_code'),
            ];

            // Validate data
            if (empty($familyCardData['family_card_no']) || empty($familyCardData['father_name']) || empty($familyCardData['mother_name'])) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data kartu keluarga tidak lengkap']);
            }

            // Check if family card data already exists
            $familyCard = $this->familyCardModel->where('student_id', $studentId)->first();
            
            // Save or update family card data
            if ($familyCard) {
                $familyCardData['id'] = $familyCard['id'];
                $this->familyCardModel->save($familyCardData);
            } else {
                $this->familyCardModel->save($familyCardData);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data kartu keluarga berhasil disimpan']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Langkah tidak valid']);
    }

    public function submitRegistration()
    {
        // Ensure user is logged in and is a student
        if (!session()->has('user_id') || session()->get('role') !== 'siswa') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        // Get active academic year
        $academicYear = $this->academicYearModel->getActive();
        
        // Get student data
        $student = $this->studentModel->where('user_id', session()->get('user_id'))->first();
        
        if (!$student) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data siswa tidak ditemukan']);
        }

        // Check if all required data is filled
        $priorSchool = $this->priorSchoolModel->where('student_id', $student['id'])->first();
        $addresses = $this->addressModel->where('student_id', $student['id'])->findAll();
        $parents = $this->parentModel->where('student_id', $student['id'])->findAll();
        $familyCard = $this->familyCardModel->where('student_id', $student['id'])->first();

        if (!$priorSchool || count($addresses) < 2 || count($parents) < 2 || !$familyCard) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Harap lengkapi semua data sebelum mengirim formulir pendaftaran']);
        }

        // Generate registration number if not exists
        $submission = $this->submissionModel->where('student_id', $student['id'])->first();
        $registrationNo = $submission['registration_no'] ?? $this->sequenceModel->generateRegistrationNo();
        
        // Prepare submission data
        $submissionData = [
            'student_id' => $student['id'],
            'registration_no' => $registrationNo,
            'status' => 'menunggu_verifikasi',
        ];
        
        // Add academic year if exists
        if ($academicYear) {
            $submissionData['academic_year_id'] = $academicYear['id'];
        }

        // Save or update submission
        if ($submission) {
            $submissionData['id'] = $submission['id'];
            $this->submissionModel->save($submissionData);
        } else {
            $this->submissionModel->save($submissionData);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Formulir pendaftaran berhasil dikirim']);
    }
}