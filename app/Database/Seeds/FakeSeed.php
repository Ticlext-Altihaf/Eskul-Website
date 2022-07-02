<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FakeSeed extends Seeder
{
    public function run()
    {
        $this->call('ClubSeed');
    }
}