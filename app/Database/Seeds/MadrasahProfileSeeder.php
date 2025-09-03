<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MadrasahProfileSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name' => 'Madrasah Ibtidaiyah Contoh',
            'npsn' => '12345678',
            'nsm' => '23456789',
            'nss' => '34567890',
            'address' => 'Jalan Pendidikan No. 123',
            'district' => 'Kecamatan Pendidikan',
            'regency' => 'Kabupaten Pendidikan',
            'province' => 'Provinsi Pendidikan',
            'postal_code' => '12345',
            'phone' => '(021) 123456',
            'email' => 'info@mi-contoh.sch.id',
            'website' => 'www.mi-contoh.sch.id',
            'headmaster_name' => 'Drs. Kepala Madrasah',
            'headmaster_nip' => '197001012000011001',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Using Query Builder
        $this->db->table('madrasah_profile')->insert($data);
    }
}