<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAddressesTable extends Migration
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
            'student_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'address_type' => [
                'type' => 'ENUM',
                'constraint' => ['kk', 'domisili'],
            ],
            'address_line' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'regency' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'district' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'village' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'distance_km' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'transport_mode' => [
                'type' => 'ENUM',
                'constraint' => ['jalan_kaki', 'sepeda', 'motor', 'mobil', 'angkot', 'lainnya'],
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey('student_id');
        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('addresses');
    }

    public function down()
    {
        $this->forge->dropTable('addresses');
    }
}