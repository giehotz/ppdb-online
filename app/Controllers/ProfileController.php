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
     * Show the profile page
     *
     * @return string
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Please login first');
        }

        return view('profile/index', [
            'title' => 'Profile',
            'user' => $user
        ]);
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
            return redirect()->to('/login')->with('error', 'Please login first');
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
            return redirect()->to('/login')->with('error', 'Please login first');
        }

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'permit_empty|string|max_length[100]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', 'Validation failed')->with('errors', $validation->getErrors());
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
                return redirect()->back()->withInput()->with('error', 'File validation failed')->with('errors', $this->validator->getErrors());
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

        return redirect()->to('/profile')->with('success', 'Profile updated successfully');
    }

    /**
     * Change user password
     *
     * @return mixed
     */
    public function changePassword()
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
            'current_password' => 'required|string',
            'new_password' => 'required|string|min_length[8]',
            'confirm_password' => 'required|matches[new_password]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validation->getErrors()
            ]);
        }

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');

        // Verify current password
        if (!password_verify($currentPassword, $user['password_hash'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Current password is incorrect'
            ]);
        }

        // Update password
        $this->userModel->update($userId, [
            'password_hash' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Password changed successfully'
        ]);
    }
}