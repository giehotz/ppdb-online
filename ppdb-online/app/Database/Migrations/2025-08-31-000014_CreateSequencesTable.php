<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSequencesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'period' => [
                'type' => 'VARCHAR',
                'constraint' => '9',
            ],
            'counter' => [
                'type' => 'INT',
                'default' => 0,
            ],
        ]);
        
        $this->forge->addKey('period', true);
        $this->forge->createTable('sequences');
    }

    public function down()
    {
        $this->forge->dropTable('sequences');
    }
}