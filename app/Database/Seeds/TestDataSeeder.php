<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;
use App\Models\StudentModel;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $studentModel = new StudentModel();
        
        // Create a test student user
        $userData = [
            'username' => 'teststudent',
            'email' => 'student@example.com',
            'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'siswa',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        $userId = $userModel->insert($userData);
        
        // Create a test student profile
        $studentData = [
            'user_id' => $userId,
            'nisn' => '1234567890',
            'nik' => '1234567890123456',
            'full_name' => 'Test Student',
            'birth_place' => 'Test City',
            'birth_date' => '2010-01-01',
            'gender' => 'L',
            'class_level' => 1,
            'student_status' => 'baru',
            'siblings_count' => 1,
            'submission_state' => 'submitted',
            'submitted_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        $studentId = $studentModel->insert($studentData);
        
        // Create a test panitia user
        $panitiaData = [
            'username' => 'testpanitia',
            'email' => 'panitia@example.com',
            'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'panitia',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        $userModel->insert($panitiaData);
        
        echo "Test data seeded successfully.\n";
    }
}