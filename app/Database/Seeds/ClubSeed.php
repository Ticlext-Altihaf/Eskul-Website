<?php
namespace App\Database\Seeds;

use App\Models\ClubModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\Test\Fabricator;

class ClubSeed extends Seeder
{
    public function run()
    {
        $clubModel = new ClubModel();
        $fabricator = new Fabricator(ClubModel::class, null, 'id_ID');
        $clubs = $fabricator->make(10);
        $clubModel->insertBatch($clubs);
    }
}