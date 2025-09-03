<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Show the profile edit form
     *
     * @return string
     */
    public function edit()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        return view('profile/edit', [
            'title' => 'Update Profile',
            'user' => $user
        ]);
    }

    /**
     * Update user profile
     *
     * @return mixed
     */
    public function update()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not found'
            ]);
        }

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'permit_empty|string|max_length[100]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validation->getErrors()
            ]);
        }

        $name = $this->request->getPost('name');
        $profilePhoto = $this->request->getFile('profile_photo');

        $updateData = [
            'name' => $name
        ];

        // Handle profile photo upload
        if ($profilePhoto && $profilePhoto->isValid() && !$profilePhoto->hasMoved()) {
            // Validate file
            $validated = $this->validate([
                'profile_photo' => [
                    'uploaded[profile_photo]',
                    'mime_in[profile_photo,image/jpg,image/jpeg,image/png]',
                    'max_size[profile_photo,2048]',
                ]
            ]);

            if (!$validated) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'File validation failed',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            // Create upload directory if not exists
            $uploadPath = FCPATH . 'uploads/profile_photos';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate unique filename
            $newName = $profilePhoto->getRandomName();
            $profilePhoto->move($uploadPath, $newName);

            // Delete old profile photo if exists
            if ($user['profile_photo'] && file_exists($uploadPath . '/' . $user['profile_photo'])) {
                unlink($uploadPath . '/' . $user['profile_photo']);
            }

            $updateData['profile_photo'] = $newName;
        }

        // Update user data
        $this->userModel->update($userId, $updateData);

        // Update session data
        session()->set([
            'name' => $name ?? $user['username'],
            'profile_photo' => $updateData['profile_photo'] ?? $user['profile_photo']
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => [
                'name' => $name ?? $user['username'],
                'profile_photo' => $updateData['profile_photo'] ?? $user['profile_photo']
            ]
        ]);
    }
}