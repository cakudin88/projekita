<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCounselingRequestsTable170000 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'student_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'type'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'theme'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'description'   => ['type' => 'TEXT', 'null' => true],
            'status'        => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected', 'scheduled', 'completed'], 'default' => 'pending'],
            'requested_at'  => ['type' => 'DATETIME', 'null' => true],
            'scheduled_at'  => ['type' => 'DATETIME', 'null' => true],
            'approved_by'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'approved_at'   => ['type' => 'DATETIME', 'null' => true],
            'group_name'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('approved_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('counseling_requests', true);
    }

    public function down()
    {
        $this->forge->dropTable('counseling_requests', true);
    }
}
