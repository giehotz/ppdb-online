<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestSubmissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'student_id' => 1,
            'registration_no' => 'PPDB-2025-0001',
            'status' => 'menunggu_verifikasi',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        // Insert the submission
        $this->db->table('submissions')->insert($data);
        
        echo "Test submission created successfully.\n";
    }
}