<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCommentsTable extends Migration
{
	public function up()
	{
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null' => false,
                ],
                'text' => [
                    'type' => 'TEXT',
                    'null' => false,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => false
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('comments');
	}

	public function down()
	{
            $this->forge->dropTable('comments');
	}
}
