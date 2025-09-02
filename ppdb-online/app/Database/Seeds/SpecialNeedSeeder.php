<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SpecialNeedSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'code' => 'tuna_rungu',
                'label' => 'Tuna Rungu',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'code' => 'tuna_netra',
                'label' => 'Tuna Netra',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'code' => 'tuna_daksa',
                'label' => 'Tuna Daksa',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'code' => 'tuna_grahita',
                'label' => 'Tuna Grahita',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'code' => 'tuna_laras',
                'label' => 'Tuna Laras',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 6,
                'code' => 'lamban_belajar',
                'label' => 'Lamban Belajar',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 7,
                'code' => 'sulit_belajar',
                'label' => 'Sulit Belajar',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 8,
                'code' => 'gangguan_komunikasi',
                'label' => 'Gangguan Komunikasi',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 9,
                'code' => 'bakat_luar_biasa',
                'label' => 'Bakat Luar Biasa',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ];

        // Using Query Builder
        $this->db->table('special_needs')->insertBatch($data);
    }
}