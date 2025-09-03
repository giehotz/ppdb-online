<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'year_label' => '2025/2026',
            'wave' => 1,
            'start_date' => '2025-06-01',
            'end_date' => '2025-08-31',
            'announcement_date' => '2025-09-15',
            'quota_total' => 150,
            'quota_per_class' => json_encode([
                'VIIA' => 30,
                'VIIB' => 30,
                'VIIC' => 30,
                'VOID' => 30,
                'VEID' => 30
            ]),
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Using Query Builder
        $this->db->table('academic_years')->insert($data);
    }
}