<?php

namespace App\Database\Migrations;

use App\Models\ClubModel;
use CodeIgniter\Database\Migration;

class BasicSetupClubs extends Migration
{
    public function up()
    {

        ClubModel::make_forge($this->forge);
    }
    public function down()
    {

        ClubModel::destroy_forge($this->forge);
    }
}