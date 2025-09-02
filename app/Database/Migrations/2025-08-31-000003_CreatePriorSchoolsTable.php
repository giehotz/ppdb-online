<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePriorSchoolsTable extends Migration
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
            'school_name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'school_level' => [
                'type' => 'ENUM',
                'constraint' => ['TK', 'RA', 'SD', 'Lainnya'],
            ],
            'school_type' => [
                'type' => 'ENUM',
                'constraint' => ['negeri', 'swasta'],
            ],
            'accreditation_status' => [
                'type' => 'ENUM',
                'constraint' => ['terakreditasi', 'tidak_terakreditasi', 'unknown'],
                'default' => 'unknown',
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->createTable('prior_schools');
    }

    public function down()
    {
        $this->forge->dropTable('prior_schools');
    }
}