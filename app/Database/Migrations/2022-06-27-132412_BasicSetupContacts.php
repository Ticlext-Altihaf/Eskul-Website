<?php

namespace App\Database\Migrations;

use App\Models\ClubModel;
use CodeIgniter\Database\Migration;

class BasicSetupContacts extends Migration
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
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'href' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('contacts');
    }
    public function down()
    {
        $this->forge->dropTable('contacts');
    }
}