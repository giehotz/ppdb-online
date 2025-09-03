<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class SettingsController extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    /**
     * Show the settings form
     */
    public function index()
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Get all settings
        $settings = $this->settingModel->findAll();
        
        // Convert to associative array for easier access
        $settingsArray = [];
        foreach ($settings as $setting) {
            $settingsArray[$setting['key']] = $setting['value'];
        }

        $data = [
            'title' => 'Pengaturan Sistem',
            'settings' => $settingsArray
        ];

        return view('admin/settings/form', $data);
    }

    /**
     * Save settings
     */
    public function save()
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        // Get all post data
        $postData = $this->request->getPost();
        
        // Save each setting
        foreach ($postData as $key => $value) {
            // Skip CSRF token
            if ($key === 'csrf_token') {
                continue;
            }
            
            // Check if setting already exists
            $existingSetting = $this->settingModel->where('key', $key)->first();
            
            if ($existingSetting) {
                // Update existing setting
                $this->settingModel->update($existingSetting['id'], [
                    'value' => $value,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                // Create new setting
                $this->settingModel->insert([
                    'key' => $key,
                    'value' => $value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Pengaturan berhasil disimpan.']);
    }
}