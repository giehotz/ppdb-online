<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Run all seeders in the correct order
        $this->call('UserSeeder');
        $this->call('SpecialNeedSeeder');
        $this->call('CmsPostSeeder');
    }
}