<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password_hash' => '$2y$10$9DmDeiq0WJMjj/kgx1rzXe6Yjha0TXj5IG5EuFvzHiiBJIa9etgMq', // password: admin123
                'role' => 'admin',
            ],
            [
                'username' => 'minduatanggamuss',
                'email' => 'min2tanggamus@gmail.com',
                'password_hash' => '$2y$10$cSz4sM6gm3ngijGis.2QTuVdkvESs2pV1pjq02uspMv1nYOufuYLC', // password: admin123
                'role' => 'panitia',
            ],
            [
                'username' => 'panitia',
                'email' => 'panitia@example.com',
                'password_hash' => '$2y$10$cpkjVwDVFzeSRaYP0NhZ0.gIZY9o9tZTOppZa6Yx3QnCWJV62aoyG', // password: panitia123
                'role' => 'panitia',
            ],
            [
                'username' => 'panitia1',
                'email' => 'panitia1@example.com',
                'password_hash' => '$2y$10$3tyebtEjmV0RGNZnYHAWD.P4zLuNy6.2tXWu/cXmqeo.5udRzYZ0u', // password: panitia123
                'role' => 'panitia',
            ],
            [
                'username' => 'siswa',
                'email' => 'siswa@example.com',
                'password_hash' => '$2y$10$vQup.G01m96E44huHIrIy.385ET3A70fP5JDF3G228Cq7RCN5cBfG', // password: siswa123
                'role' => 'siswa',
            ],
        ];

        $userModel = model('App\Models\UserModel');
        
        foreach ($users as $user) {
            // Check if user already exists
            $existingUser = $userModel->where('email', $user['email'])->first();
            
            if ($existingUser) {
                // Update existing user but keep original password if not changed
                $user['updated_at'] = date('Y-m-d H:i:s');
                $userModel->update($existingUser['id'], $user);
            } else {
                // Create new user
                $user['created_at'] = date('Y-m-d H:i:s');
                $user['updated_at'] = date('Y-m-d H:i:s');
                $userModel->insert($user);
            }
        }
    }
}