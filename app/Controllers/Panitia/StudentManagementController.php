<?php

namespace App\Controllers\Panitia;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\AddressModel;
use App\Models\ParentModel;
use App\Models\PriorSchoolModel;
use App\Models\FamilyCardModel;
use App\Models\DocumentModel;
use App\Models\UserModel;

class StudentManagementController extends BaseController
{
    protected $studentModel;
    protected $addressModel;
    protected $parentModel;
    protected $priorSchoolModel;
    protected $familyCardModel;
    protected $documentModel;
    protected $userModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->addressModel = new AddressModel();
        $this->parentModel = new ParentModel();
        $this->priorSchoolModel = new PriorSchoolModel();
        $this->familyCardModel = new FamilyCardModel();
        $this->documentModel = new DocumentModel();
        $this->userModel = new UserModel();
    }

    /**
     * Display list of all students
     */
    public function index()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        // Get all students with their submission status
        $students = $this->studentModel
            ->select('students.*, submissions.status as submission_status, users.username')
            ->join('submissions', 'students.id = submissions.student_id', 'left')
            ->join('users', 'students.user_id = users.id', 'left')
            ->findAll();

        $data = [
            'title' => 'Manajemen Data Siswa',
            'students' => $students
        ];

        return view('panitia/students/index', $data);
    }

    /**
     * Show form to add new student (offline registration)
     */
    public function create()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Tambah Data Siswa'
        ];

        return view('panitia/students/form', $data);
    }

    /**
     * Save new student data (offline registration)
     */
    public function store()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        // Create user account for student
        $userData = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'email' => $this->request->getPost('email'),
            'role' => 'siswa',
            'is_active' => 1
        ];

        // Validate user data
        if (empty($userData['username']) || empty($userData['password'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Username dan password harus diisi']);
        }

        // Check if username already exists
        if ($this->userModel->where('username', $userData['username'])->first()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Username sudah digunakan']);
        }

        // Save user
        $userId = $this->userModel->insert($userData);
        if (!$userId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal membuat akun siswa']);
        }

        // Save student data
        $studentData = [
            'user_id' => $userId,
            'nisn' => $this->request->getPost('nisn'),
            'nik' => $this->request->getPost('nik'),
            'full_name' => $this->request->getPost('full_name'),
            'birth_place' => $this->request->getPost('birth_place'),
            'birth_date' => $this->request->getPost('birth_date'),
            'gender' => $this->request->getPost('gender'),
            'student_status' => $this->request->getPost('student_status'),
            'hobby' => $this->request->getPost('hobby'),
            'aspiration' => $this->request->getPost('aspiration'),
            'submission_state' => 'submitted'
        ];

        $studentId = $this->studentModel->insert($studentData);
        if (!$studentId) {
            // Delete user if student creation fails
            $this->userModel->delete($userId);
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan data siswa']);
        }

        return $this->response->setJSON([
            'status' => 'success', 
            'message' => 'Data siswa berhasil disimpan',
            'redirect' => '/panitia/students'
        ]);
    }

    /**
     * Show form to edit student data
     */
    public function edit($studentId)
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        // Get student data
        $student = $this->studentModel->find($studentId);
        if (!$student) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data siswa tidak ditemukan");
        }

        // Get related data
        $addresses = $this->addressModel->where('student_id', $studentId)->findAll();
        $parents = $this->parentModel->where('student_id', $studentId)->findAll();
        $priorSchool = $this->priorSchoolModel->where('student_id', $studentId)->first();
        $familyCard = $this->familyCardModel->where('student_id', $studentId)->first();

        // Separate KK and domisili addresses
        $kkAddress = null;
        $domisiliAddress = null;
        foreach ($addresses as $address) {
            if ($address['type'] === 'kk') {
                $kkAddress = $address;
            } elseif ($address['type'] === 'domisili') {
                $domisiliAddress = $address;
            }
        }

        // Separate father and mother data
        $father = null;
        $mother = null;
        foreach ($parents as $parent) {
            if ($parent['relation'] === 'father') {
                $father = $parent;
            } elseif ($parent['relation'] === 'mother') {
                $mother = $parent;
            }
        }

        $data = [
            'title' => 'Edit Data Siswa',
            'student' => $student,
            'kkAddress' => $kkAddress,
            'domisiliAddress' => $domisiliAddress,
            'father' => $father,
            'mother' => $mother,
            'priorSchool' => $priorSchool,
            'familyCard' => $familyCard
        ];

        return view('panitia/students/form', $data);
    }

    /**
     * Update student data
     */
    public function update($studentId)
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        // Get student data
        $student = $this->studentModel->find($studentId);
        if (!$student) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data siswa tidak ditemukan']);
        }

        // Determine which step we're saving
        $step = $this->request->getPost('step');
        
        if ($step == 'personal') {
            // Update student personal data
            $data = [
                'id' => $studentId,
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

            if ($this->studentModel->save($data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Data pribadi berhasil diperbarui']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui data pribadi']);
            }
            
        } else if ($step == 'school') {
            // Update school data
            $data = [
                'student_id' => $studentId,
                'school_name' => $this->request->getPost('school_name'),
                'school_type' => $this->request->getPost('school_type'),
                'school_address' => $this->request->getPost('school_address'),
                'graduation_year' => $this->request->getPost('graduation_year'),
            ];

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

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data sekolah berhasil diperbarui']);
            
        } else if ($step == 'address') {
            // Update KK address
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

            // Update domisili address
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

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data alamat berhasil diperbarui']);
            
        } else if ($step == 'parents') {
            // Update father data
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

            // Update mother data
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

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data orang tua berhasil diperbarui']);
            
        } else if ($step == 'family_card') {
            // Update family card data
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

            // Check if family card data already exists
            $familyCard = $this->familyCardModel->where('student_id', $studentId)->first();
            
            // Save or update family card data
            if ($familyCard) {
                $familyCardData['id'] = $familyCard['id'];
                $this->familyCardModel->save($familyCardData);
            } else {
                $this->familyCardModel->save($familyCardData);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'Data kartu keluarga berhasil diperbarui']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Langkah tidak valid']);
    }

    /**
     * Delete student data
     */
    public function delete($studentId)
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        // Get student data
        $student = $this->studentModel->find($studentId);
        if (!$student) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data siswa tidak ditemukan']);
        }

        // Delete related data
        $this->addressModel->where('student_id', $studentId)->delete();
        $this->parentModel->where('student_id', $studentId)->delete();
        $this->priorSchoolModel->where('student_id', $studentId)->delete();
        $this->familyCardModel->where('student_id', $studentId)->delete();
        $this->documentModel->where('student_id', $studentId)->delete();
        
        // Delete student
        $this->studentModel->delete($studentId);
        
        // Delete user account
        if ($student['user_id']) {
            $this->userModel->delete($student['user_id']);
        }

        return $this->response->setJSON([
            'status' => 'success', 
            'message' => 'Data siswa berhasil dihapus',
            'redirect' => '/panitia/students'
        ]);
    }
}