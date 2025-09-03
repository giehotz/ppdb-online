<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMadrasahProfileTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'npsn' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'unique' => true,
            ],
            'nsm' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'nss' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'district' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'regency' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true,
            ],
            'website' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true,
            ],
            'headmaster_name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'headmaster_nip' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => true,
            ],
            'logo_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'letterhead_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        // Hapus baris berikut karena indeks sudah didefinisikan dengan 'unique' => true di field npsn
        // $this->forge->addKey('npsn', false, true);
        $this->forge->createTable('madrasah_profile');
    }

    public function down()
    {
        $this->forge->dropTable('madrasah_profile');
    }
}