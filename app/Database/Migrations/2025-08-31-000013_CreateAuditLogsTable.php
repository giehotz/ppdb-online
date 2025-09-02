<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuditLogsTable extends Migration
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
            'actor_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'action' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'entity_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'entity_id' => [
                'type' => 'INT',
            ],
            'before_json' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Full row snapshot atau hanya changed fields',
            ],
            'after_json' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Full row snapshot atau hanya changed fields',
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey('actor_user_id');
        $this->forge->addKey(['entity_type', 'entity_id']);
        $this->forge->addForeignKey('actor_user_id', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('audit_logs');
    }

    public function down()
    {
        $this->forge->dropTable('audit_logs');
    }
}