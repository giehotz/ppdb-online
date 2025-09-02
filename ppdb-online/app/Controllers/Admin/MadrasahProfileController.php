<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MadrasahProfileModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MadrasahProfileController extends BaseController
{
    protected $madrasahProfileModel;

    public function __construct()
    {
        $this->madrasahProfileModel = new MadrasahProfileModel();
    }

    /**
     * Show the madrasah profile form
     */
    public function index()
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Get existing profile or create empty one
        $profile = $this->madrasahProfileModel->first();

        $data = [
            'title' => 'Profil Madrasah',
            'profile' => $profile
        ];

        return view('admin/madrasah_profile/form', $data);
    }

    /**
     * Save or update madrasah profile
     */
    public function save()
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $id = $this->request->getPost('id');

        $data = [
            'name' => $this->request->getPost('name'),
            'npsn' => $this->request->getPost('npsn'),
            'nsm' => $this->request->getPost('nsm'),
            'nss' => $this->request->getPost('nss'),
            'address' => $this->request->getPost('address'),
            'district' => $this->request->getPost('district'),
            'regency' => $this->request->getPost('regency'),
            'province' => $this->request->getPost('province'),
            'postal_code' => $this->request->getPost('postal_code'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'website' => $this->request->getPost('website'),
            'headmaster_name' => $this->request->getPost('headmaster_name'),
            'headmaster_nip' => $this->request->getPost('headmaster_nip'),
        ];

        // Handle file uploads
        $logo = $this->request->getFile('logo');
        $letterhead = $this->request->getFile('letterhead');

        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            // Validate file type and size
            $allowedTypes = ['jpg', 'jpeg', 'png'];
            if (!in_array($logo->getExtension(), $allowedTypes)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Tipe file logo tidak diizinkan. Hanya JPG, JPEG, dan PNG yang diizinkan.']);
            }

            // Max file size: 2MB
            if ($logo->getSize() > 2 * 1024 * 1024) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Ukuran file logo terlalu besar. Maksimal 2MB.']);
            }

            // Generate unique filename
            $newName = 'logo_' . $logo->getRandomName();
            
            // Upload directory
            $uploadPath = WRITEPATH . 'uploads/madrasah/';
            
            // Create directory if not exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Move file to upload directory
            if ($logo->move($uploadPath, $newName)) {
                $data['logo_path'] = 'uploads/madrasah/' . $newName;
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengunggah logo.']);
            }
        }

        if ($letterhead && $letterhead->isValid() && !$letterhead->hasMoved()) {
            // Validate file type and size
            $allowedTypes = ['jpg', 'jpeg', 'png'];
            if (!in_array($letterhead->getExtension(), $allowedTypes)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Tipe file kop surat tidak diizinkan. Hanya JPG, JPEG, dan PNG yang diizinkan.']);
            }

            // Max file size: 2MB
            if ($letterhead->getSize() > 2 * 1024 * 1024) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Ukuran file kop surat terlalu besar. Maksimal 2MB.']);
            }

            // Generate unique filename
            $newName = 'letterhead_' . $letterhead->getRandomName();
            
            // Upload directory
            $uploadPath = WRITEPATH . 'uploads/madrasah/';
            
            // Move file to upload directory
            if ($letterhead->move($uploadPath, $newName)) {
                $data['letterhead_path'] = 'uploads/madrasah/' . $newName;
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengunggah kop surat.']);
            }
        }

        // Save or update profile
        if ($id) {
            // Update existing profile
            $data['id'] = $id;
            if ($this->madrasahProfileModel->save($data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Profil madrasah berhasil diperbarui.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui profil madrasah.']);
            }
        } else {
            // Create new profile
            if ($this->madrasahProfileModel->save($data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Profil madrasah berhasil disimpan.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan profil madrasah.']);
            }
        }
    }
}