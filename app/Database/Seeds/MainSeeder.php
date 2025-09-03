<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // Seed users first
        $this->call('UserSeeder');
        
        // Seed academic years
        $this->call('AcademicYearSeeder');
        
        // Seed settings
        $this->call('SettingSeeder');
        
        // Seed CMS content
        $this->call('CMSSeeder');
    }
}