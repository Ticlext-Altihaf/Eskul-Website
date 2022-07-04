<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Admin extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'role' => [
                'type' => 'enum',
                'constraint' => ['admin', 'editor', 'editor_club','guest'],
            ],
            'admin_club' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('username', true);
        $this->forge->createTable('admins');

    }

    public function down()
    {
        $this->forge->dropTable('admins');
    }
}
