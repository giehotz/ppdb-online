<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentSpecialNeedsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'student_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'special_need_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        
        $this->forge->addKey(['student_id', 'special_need_id'], true);
        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('special_need_id', 'special_needs', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('student_special_needs');
    }

    public function down()
    {
        $this->forge->dropTable('student_special_needs');
    }
}