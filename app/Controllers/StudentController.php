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
use App\Models\AnnouncementModel;

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
    protected $announcementModel;

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
        $this->announcementModel = new AnnouncementModel();
    }

    public function dashboard()
    {
        // Ensure user is logged in and is a student
        if (!session()->has('user_id') || session()->get('role') !== 'siswa') {
            // Redirect to login with error message
            session()->setFlashdata('error', 'Akses ditolak. Anda harus login sebagai siswa.');
            return redirect()->to('/login');
        }

        // Get student data
        $student = $this->studentModel->where('user_id', session()->get('user_id'))->first();

        // Get submission data if student exists
        $submission = null;
        if ($student) {
            $submission = $this->submissionModel->where('student_id', $student['id'])->first();
        }

        // Get latest announcements
        $announcements = $this->announcementModel->getLatest(5);

        $data = [
            'title' => 'Dashboard Siswa',
            'student' => $student,
            'submission' => $submission,
            'announcements' => $announcements
        ];

        return view('student/dashboard', $data);
    }

    /**
     * Validate that the current user is a student
     */
    protected function validateStudentRole()
    {
        return session()->has('user_id') && session()->get('role') === 'siswa';
    }

    /**
     * Handle unauthorized access attempts
     */
    protected function handleUnauthorizedAccess()
    {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(403);
        }

        // Redirect to login with error message
        session()->setFlashdata('error', 'Akses ditolak. Anda harus login sebagai siswa.');
        return redirect()->to('/login');
    }

    /**
     * Get student data with enhanced validation
     */
    protected function getStudentData()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return null;
        }

        // Try to get student data with multiple approaches to avoid false negatives
        $student = $this->studentModel->where('user_id', $userId)->first();

        // If not found, try with fresh connection
        if (!$student) {
            $this->studentModel->db->reconnect();
            $student = $this->studentModel->where('user_id', $userId)->first();
        }

        return $student;
    }

    public function registrationForm()
    {
        // Log access to this method
        log_message('info', 'Accessing registrationForm method');

        // Validate user role first
        if (!$this->validateStudentRole()) {
            log_message('info', 'Unauthorized access to registrationForm');
            return $this->handleUnauthorizedAccess();
        }

        // Get active academic year
        $academicYear = $this->academicYearModel->getActive();

        // Get existing student data if available
        $student = $this->getStudentData();

        log_message('info', 'Student data retrieved: ' . json_encode($student));

        // Get related data if student exists
        if ($student) {
            // Get school data
            $student['prior_school'] = $this->priorSchoolModel
                ->where('student_id', $student['id'])
                ->first();

            // Get address data
            $addresses = $this->addressModel
                ->where('student_id', $student['id'])
                ->findAll();

            foreach ($addresses as $address) {
                if ($address['address_type'] === 'kk') {
                    $student['kk_address'] = $address;
                } else if ($address['address_type'] === 'domisili') {
                    $student['domisili_address'] = $address;
                }
            }

            // Get parent data
            $parents = $this->parentModel
                ->where('student_id', $student['id'])
                ->findAll();

            foreach ($parents as $parent) {
                if ($parent['relation'] === 'ayah') {
                    $student['father'] = $parent;
                } else if ($parent['relation'] === 'ibu') {
                    $student['mother'] = $parent;
                }
            }

            // Get family card data
            $student['family_card'] = $this->familyCardModel
                ->where('student_id', $student['id'])
                ->first();
        }

        $data = [
            'title' => 'Formulir Pendaftaran Siswa',
            'student' => $student,
            'academicYear' => $academicYear
        ];

        return view('student/registration_form', $data);
    }

    public function savePersonal()
    {
        // Validate user role first
        if (!$this->validateStudentRole()) {
            return $this->handleUnauthorizedAccess();
        }

        // Log incoming request data
        log_message('debug', 'SavePersonal method called');
        log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));

        // Collect data from request
        $data = [
            'user_id' => session()->get('user_id'),
            'nis_local' => $this->request->getPost('nis_local'),
            'nisn' => $this->request->getPost('nisn'),
            'nik' => $this->request->getPost('nik'),
            'full_name' => $this->request->getPost('full_name'),
            'birth_place' => $this->request->getPost('birth_place'),
            'birth_date' => $this->request->getPost('birth_date'),
            'gender' => $this->request->getPost('gender'),
            'class_level' => $this->request->getPost('class_level') ?? 1,
            'parallel_class' => $this->request->getPost('parallel_class'),
            'attendance_no' => $this->request->getPost('attendance_no'),
            'class_rank' => $this->request->getPost('class_rank'),
            'student_status' => $this->request->getPost('student_status'),
            'hobby' => $this->request->getPost('hobby'),
            'aspiration' => $this->request->getPost('aspiration'),
            'siblings_count' => $this->request->getPost('siblings_count') ?? 0,
            'submission_state' => 'draft'
        ];

        log_message('debug', 'Personal data to save: ' . json_encode($data));

        // Validate data
        if (empty($data['nisn']) || empty($data['nik']) || empty($data['full_name'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tidak lengkap',
                'errors' => [
                    'nisn' => empty($data['nisn']) ? 'NISN harus diisi' : '',
                    'nik' => empty($data['nik']) ? 'NIK harus diisi' : '',
                    'full_name' => empty($data['full_name']) ? 'Nama lengkap harus diisi' : ''
                ]
            ]);
        }

        // Save or update data
        try {
            // Check if student data already exists for this user
            $existingStudent = $this->studentModel
                ->where('user_id', session()->get('user_id'))
                ->first();

            log_message('debug', 'Existing student data: ' . json_encode($existingStudent));

            if ($existingStudent) {
                // Update existing record
                $data['id'] = $existingStudent['id'];
                $result = $this->studentModel->save($data);
                log_message('debug', 'Student data updated, result: ' . var_export($result, true));
            } else {
                // Create new record
                $result = $this->studentModel->save($data);
                log_message('debug', 'Student data inserted, result: ' . var_export($result, true));
            }

            // Check if save was successful
            if ($result === false) {
                $errors = $this->studentModel->errors();
                log_message('error', 'StudentModel errors: ' . json_encode($errors));
                return $this->response->setStatusCode(422)->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan data pribadi',
                    'errors' => $errors
                ]);
            }

            // Store student_id in session for future steps
            $student_id = $existingStudent ? $existingStudent['id'] : $this->studentModel->getInsertID();
            session()->set('student_id', $student_id);
            log_message('debug', 'Student ID stored in session: ' . $student_id);

            // Success response
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data pribadi berhasil disimpan',
                'student_id' => $student_id
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Exception in savePersonal: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data pribadi. Silakan coba lagi.'
            ]);
        } catch (\Error $e) {
            log_message('error', 'Error in savePersonal: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data pribadi. Silakan coba lagi.'
            ]);
        }
    }

    public function saveSchool()
    {
        // Validate user role first
        if (!$this->validateStudentRole()) {
            return $this->handleUnauthorizedAccess();
        }

        // Log incoming request data
        log_message('debug', 'SaveSchool method called');
        log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));

        // Get student ID with priority order
        $studentId = $this->request->getPost('student_id') ?? session()->get('student_id');
        log_message('debug', 'Student ID from POST/session: ' . $studentId);

        // Validate student ID
        if (empty($studentId)) {
            log_message('error', 'Student ID is missing in saveSchool request');
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID siswa tidak ditemukan. Silakan isi data pribadi terlebih dahulu.'
            ]);
        }

        // Verify student exists
        $student = $this->studentModel->find($studentId);
        if (!$student) {
            log_message('error', 'Student not found with ID: ' . $studentId);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data siswa tidak ditemukan. Silakan isi data pribadi terlebih dahulu.'
            ]);
        }

        log_message('debug', 'Student found: ' . json_encode($student));

        // Collect data from request
        $data = [
            'student_id' => $studentId,
            'school_name' => $this->request->getPost('school_name'),
            'school_level' => $this->request->getPost('school_level'),
            'school_type' => $this->request->getPost('school_type'),
            'accreditation_status' => $this->request->getPost('accreditation_status'),
            'city' => $this->request->getPost('city'),
        ];

        log_message('debug', 'School data to save: ' . json_encode($data));

        // Save or update data
        try {
            // Check if school data already exists for this student
            $existingSchool = $this->priorSchoolModel
                ->where('student_id', $studentId)
                ->first();

            log_message('debug', 'Existing school data: ' . json_encode($existingSchool));

            if ($existingSchool) {
                // Update existing record
                $data['id'] = $existingSchool['id'];
                $result = $this->priorSchoolModel->save($data);
                log_message('debug', 'School data updated, result: ' . var_export($result, true));
            } else {
                // Create new record
                $result = $this->priorSchoolModel->save($data);
                log_message('debug', 'School data inserted, result: ' . var_export($result, true));
            }

            // Check if save was successful
            if ($result === false) {
                $errors = $this->priorSchoolModel->errors();
                log_message('error', 'PriorSchoolModel errors: ' . json_encode($errors));
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan data sekolah',
                    'errors' => $errors
                ]);
            }

            // Success response
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data sekolah berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Exception in saveSchool: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data sekolah. Silakan coba lagi. Error: ' . $e->getMessage()
            ]);
        } catch (\Error $e) {
            log_message('error', 'Error in saveSchool: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data sekolah. Silakan coba lagi. Error: ' . $e->getMessage()
            ]);
        }
    }

    public function saveAddress()
    {
        // Validate user role first
        if (!$this->validateStudentRole()) {
            return $this->handleUnauthorizedAccess();
        }

        // Log incoming request data
        log_message('debug', 'SaveAddress method called');
        log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));

        // Get student ID from POST data
        $studentId = $this->request->getPost('student_id');
        log_message('debug', 'Student ID from POST: ' . $studentId);

        // Validate student ID
        if (empty($studentId)) {
            log_message('error', 'Student ID is missing in saveAddress request');
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID siswa tidak ditemukan. Silakan isi data pribadi terlebih dahulu.'
            ]);
        }

        // Verify student exists
        $student = $this->studentModel->find($studentId);
        if (!$student) {
            log_message('error', 'Student not found with ID: ' . $studentId);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data siswa tidak ditemukan. Silakan isi data pribadi terlebih dahulu.'
            ]);
        }

        log_message('debug', 'Student found: ' . json_encode($student));

        try {
            // Process KK address
            $kkData = [
                'student_id' => $studentId,
                'address_type' => 'kk',
                'address_line' => $this->request->getPost('kk_address_line'),
                'province' => $this->request->getPost('kk_province'),
                'regency' => $this->request->getPost('kk_regency'),
                'district' => $this->request->getPost('kk_district'),
                'village' => $this->request->getPost('kk_village'),
                'postal_code' => $this->request->getPost('kk_postal_code'),
                'distance_km' => $this->request->getPost('kk_distance_km'),
                'transport_mode' => $this->request->getPost('kk_transport_mode'),
            ];

            log_message('debug', 'KK Address data: ' . json_encode($kkData));

            // Check if KK address already exists
            $existingKK = $this->addressModel
                ->where('student_id', $studentId)
                ->where('address_type', 'kk')
                ->first();

            log_message('debug', 'Existing KK address: ' . json_encode($existingKK));

            if ($existingKK) {
                // Update existing KK record
                $kkData['id'] = $existingKK['id'];
                $kkResult = $this->addressModel->save($kkData);
                log_message('debug', 'KK address updated, result: ' . var_export($kkResult, true));
            } else {
                // Create new KK record
                $kkResult = $this->addressModel->save($kkData);
                log_message('debug', 'KK address inserted, result: ' . var_export($kkResult, true));
            }

            // Check if KK save was successful
            if ($kkResult === false) {
                $errors = $this->addressModel->errors();
                log_message('error', 'AddressModel KK errors: ' . json_encode($errors));
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan alamat KK',
                    'errors' => $errors
                ]);
            }

            // Process Domisili address
            $domisiliData = [
                'student_id' => $studentId,
                'address_type' => 'domisili',
                'address_line' => $this->request->getPost('domisili_address_line'),
                'province' => $this->request->getPost('domisili_province'),
                'regency' => $this->request->getPost('domisili_regency'),
                'district' => $this->request->getPost('domisili_district'),
                'village' => $this->request->getPost('domisili_village'),
                'postal_code' => $this->request->getPost('domisili_postal_code'),
                'distance_km' => $this->request->getPost('domisili_distance_km'),
                'transport_mode' => $this->request->getPost('domisili_transport_mode'),
            ];

            log_message('debug', 'Domisili Address data: ' . json_encode($domisiliData));

            // Check if Domisili address already exists
            $existingDomisili = $this->addressModel
                ->where('student_id', $studentId)
                ->where('address_type', 'domisili')
                ->first();

            log_message('debug', 'Existing Domisili address: ' . json_encode($existingDomisili));

            if ($existingDomisili) {
                // Update existing Domisili record
                $domisiliData['id'] = $existingDomisili['id'];
                $domisiliResult = $this->addressModel->save($domisiliData);
                log_message('debug', 'Domisili address updated, result: ' . var_export($domisiliResult, true));
            } else {
                // Create new Domisili record
                $domisiliResult = $this->addressModel->save($domisiliData);
                log_message('debug', 'Domisili address inserted, result: ' . var_export($domisiliResult, true));
            }

            // Check if Domisili save was successful
            if ($domisiliResult === false) {
                $errors = $this->addressModel->errors();
                log_message('error', 'AddressModel Domisili errors: ' . json_encode($errors));
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan alamat domisili',
                    'errors' => $errors
                ]);
            }

            // Success response
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data alamat berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Exception in saveAddress: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data alamat. Silakan coba lagi. Error: ' . $e->getMessage()
            ]);
        } catch (\Error $e) {
            log_message('error', 'Error in saveAddress: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data alamat. Silakan coba lagi. Error: ' . $e->getMessage()
            ]);
        }
    }

    public function saveParents()
    {
        // Validate user role first
        if (!$this->validateStudentRole()) {
            return $this->handleUnauthorizedAccess();
        }

        // Log incoming request data
        log_message('debug', 'SaveParents method called');
        log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));

        // Get student ID from POST data
        $studentId = $this->request->getPost('student_id');
        log_message('debug', 'Student ID from POST: ' . $studentId);

        // Validate student ID
        if (empty($studentId)) {
            log_message('error', 'Student ID is missing in saveParents request');
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID siswa tidak ditemukan. Silakan isi data pribadi terlebih dahulu.'
            ]);
        }

        // Verify student exists
        $student = $this->studentModel->find($studentId);
        if (!$student) {
            log_message('error', 'Student not found with ID: ' . $studentId);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data siswa tidak ditemukan. Silakan isi data pribadi terlebih dahulu.'
            ]);
        }

        log_message('debug', 'Student found: ' . json_encode($student));

        try {
            // Process Father data
            $fatherData = [
                'student_id' => $studentId,
                'relation' => 'ayah',
                'full_name' => $this->request->getPost('father_full_name'),
                'nik' => $this->request->getPost('father_nik'),
                'education' => $this->request->getPost('father_education'),
                'occupation' => $this->request->getPost('father_occupation'),
                'monthly_income' => $this->request->getPost('father_monthly_income'),
            ];

            log_message('debug', 'Father data: ' . json_encode($fatherData));

            // Check if Father data already exists
            $existingFather = $this->parentModel
                ->where('student_id', $studentId)
                ->where('relation', 'ayah')
                ->first();

            log_message('debug', 'Existing Father data: ' . json_encode($existingFather));

            if ($existingFather) {
                // Update existing Father record
                $fatherData['id'] = $existingFather['id'];
                $fatherResult = $this->parentModel->save($fatherData);
                log_message('debug', 'Father data updated, result: ' . var_export($fatherResult, true));
            } else {
                // Create new Father record
                $fatherResult = $this->parentModel->save($fatherData);
                log_message('debug', 'Father data inserted, result: ' . var_export($fatherResult, true));
            }

            // Check if Father save was successful
            if ($fatherResult === false) {
                $errors = $this->parentModel->errors();
                log_message('error', 'ParentModel Father errors: ' . json_encode($errors));
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan data ayah',
                    'errors' => $errors
                ]);
            }

            // Process Mother data
            $motherData = [
                'student_id' => $studentId,
                'relation' => 'ibu',
                'full_name' => $this->request->getPost('mother_full_name'),
                'nik' => $this->request->getPost('mother_nik'),
                'education' => $this->request->getPost('mother_education'),
                'occupation' => $this->request->getPost('mother_occupation'),
                'monthly_income' => $this->request->getPost('mother_monthly_income'),
            ];

            log_message('debug', 'Mother data: ' . json_encode($motherData));

            // Check if Mother data already exists
            $existingMother = $this->parentModel
                ->where('student_id', $studentId)
                ->where('relation', 'ibu')
                ->first();

            log_message('debug', 'Existing Mother data: ' . json_encode($existingMother));

            if ($existingMother) {
                // Update existing Mother record
                $motherData['id'] = $existingMother['id'];
                $motherResult = $this->parentModel->save($motherData);
                log_message('debug', 'Mother data updated, result: ' . var_export($motherResult, true));
            } else {
                // Create new Mother record
                $motherResult = $this->parentModel->save($motherData);
                log_message('debug', 'Mother data inserted, result: ' . var_export($motherResult, true));
            }

            // Check if Mother save was successful
            if ($motherResult === false) {
                $errors = $this->parentModel->errors();
                log_message('error', 'ParentModel Mother errors: ' . json_encode($errors));
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan data ibu',
                    'errors' => $errors
                ]);
            }

            // Success response
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data orang tua berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Exception in saveParents: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data orang tua. Silakan coba lagi.'
            ]);
        }
    }

    public function saveFamilyCard()
    {
        // Validate user role first
        if (!$this->validateStudentRole()) {
            return $this->handleUnauthorizedAccess();
        }

        // Log incoming request data
        log_message('debug', 'SaveFamilyCard method called');
        log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));

        // Get student ID from POST data
        $studentId = $this->request->getPost('student_id');
        log_message('debug', 'Student ID from POST: ' . $studentId);

        // Validate student ID
        if (empty($studentId)) {
            log_message('error', 'Student ID is missing in saveFamilyCard request');
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID siswa tidak ditemukan. Silakan isi data pribadi terlebih dahulu.'
            ]);
        }

        // Verify student exists
        $student = $this->studentModel->find($studentId);
        if (!$student) {
            log_message('error', 'Student not found with ID: ' . $studentId);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data siswa tidak ditemukan. Silakan isi data pribadi terlebih dahulu.'
            ]);
        }

        log_message('debug', 'Student found: ' . json_encode($student));

        // Collect data from request
        $data = [
            'student_id' => $studentId,
            'kk_number' => $this->request->getPost('kk_number'),
        ];

        log_message('debug', 'Family card data to save: ' . json_encode($data));

        // Save or update data
        try {
            // Check if family card data already exists for this student
            $existingCard = $this->familyCardModel
                ->where('student_id', $studentId)
                ->first();

            log_message('debug', 'Existing family card data: ' . json_encode($existingCard));

            if ($existingCard) {
                // Update existing record
                $data['id'] = $existingCard['id'];
                $result = $this->familyCardModel->save($data);
                log_message('debug', 'Family card data updated, result: ' . var_export($result, true));
            } else {
                // Create new record
                $result = $this->familyCardModel->save($data);
                log_message('debug', 'Family card data inserted, result: ' . var_export($result, true));
            }

            // Check if save was successful
            if ($result === false) {
                $errors = $this->familyCardModel->errors();
                log_message('error', 'FamilyCardModel errors: ' . json_encode($errors));
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan data kartu keluarga',
                    'errors' => $errors
                ]);
            }

            // Success response
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data kartu keluarga berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Exception in saveFamilyCard: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data kartu keluarga. Silakan coba lagi.'
            ]);
        }
    }

    public function submitFinal()
    {
        // Validate user role first
        if (!$this->validateStudentRole()) {
            return $this->handleUnauthorizedAccess();
        }

        // Log incoming request data
        log_message('debug', 'SubmitFinal method called');
        log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));

        // Get student ID from POST data
        $studentId = $this->request->getPost('student_id');
        log_message('debug', 'Student ID from POST: ' . $studentId);

        // Validate student ID
        if (empty($studentId)) {
            log_message('error', 'Student ID is missing in submitFinal request');
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID siswa tidak ditemukan. Silakan isi data pribadi terlebih dahulu.'
            ]);
        }

        // Verify student exists
        $student = $this->studentModel->find($studentId);
        if (!$student) {
            log_message('error', 'Student not found with ID: ' . $studentId);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data siswa tidak ditemukan. Silakan isi data pribadi terlebih dahulu.'
            ]);
        }

        log_message('debug', 'Student found: ' . json_encode($student));

        try {
            // Check if all required data exists
            $checks = [
                'personal' => $student,
                'school' => $this->priorSchoolModel->where('student_id', $studentId)->first(),
                'address' => $this->addressModel->where('student_id', $studentId)->countAllResults() >= 2,
                'parents' => $this->parentModel->where('student_id', $studentId)->countAllResults() >= 2,
                'family_card' => $this->familyCardModel->where('student_id', $studentId)->first(),
            ];

            log_message('debug', 'Validation checks: ' . json_encode($checks));

            // Validate all data exists
            foreach ($checks as $key => $value) {
                if (!$value) {
                    log_message('error', 'Missing required data: ' . $key);
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Data tidak lengkap. Silakan lengkapi semua langkah terlebih dahulu.'
                    ]);
                }
            }

            // Check if submission already exists
            $existingSubmission = $this->submissionModel
                ->where('student_id', $studentId)
                ->first();

            log_message('debug', 'Existing submission: ' . json_encode($existingSubmission));

            if ($existingSubmission) {
                // Update existing submission
                $submissionData = [
                    'id' => $existingSubmission['id'],
                    'student_id' => $studentId,
                    'registration_no' => $existingSubmission['registration_no'],
                    'status' => 'submitted'
                ];

                $result = $this->submissionModel->save($submissionData);
                log_message('debug', 'Submission updated, result: ' . var_export($result, true));
            } else {
                // Generate registration number
                $academicYear = $this->academicYearModel->getActive();
                $registrationNo = $this->sequenceModel->generateRegistrationNumber($academicYear['id'] ?? 1);

                log_message('debug', 'Generated registration number: ' . $registrationNo);

                // Create new submission
                $submissionData = [
                    'student_id' => $studentId,
                    'registration_no' => $registrationNo,
                    'status' => 'submitted'
                ];

                $result = $this->submissionModel->save($submissionData);
                log_message('debug', 'Submission inserted, result: ' . var_export($result, true));
            }

            // Check if save was successful
            if ($result === false) {
                $errors = $this->submissionModel->errors();
                log_message('error', 'SubmissionModel errors: ' . json_encode($errors));
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan pengajuan',
                    'errors' => $errors
                ]);
            }

            // Update student status to 'submitted'
            $studentUpdateResult = $this->studentModel->update($studentId, ['submission_state' => 'submitted']);
            log_message('debug', 'Student status updated, result: ' . var_export($studentUpdateResult, true));

            // Success response
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Formulir berhasil diajukan'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Exception in submitFinal: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengirim formulir. Silakan coba lagi.'
            ]);
        }
    }
}
