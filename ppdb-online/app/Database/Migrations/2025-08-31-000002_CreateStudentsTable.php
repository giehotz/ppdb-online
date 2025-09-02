<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentsTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'nullable jika dibuat panitia untuk siswa offline',
            ],
            'nis_local' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'nisn' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => '16',
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'birth_place' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'birth_date' => [
                'type' => 'DATE',
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
            ],
            'class_level' => [
                'type' => 'INT',
                'comment' => '1..6',
            ],
            'parallel_class' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
                'null' => true,
            ],
            'attendance_no' => [
                'type' => 'INT',
                'null' => true,
            ],
            'class_rank' => [
                'type' => 'INT',
                'null' => true,
            ],
            'student_status' => [
                'type' => 'ENUM',
                'constraint' => ['baru', 'pindahan'],
                'default' => 'baru',
            ],
            'hobby' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'aspiration' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'siblings_count' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'submission_state' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'submitted'],
                'default' => 'draft',
            ],
            'submitted_at' => [
                'type' => 'DATETIME',
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey('nisn');
        $this->forge->addKey('nik');
        $this->forge->addKey('full_name');
        $this->forge->addKey('birth_date');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}