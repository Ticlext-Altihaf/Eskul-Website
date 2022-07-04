<?php

namespace App\Database\Seeds;

use App\Models\ClubModel;
use Aspera\Spreadsheet\XLSX\Reader;
use CodeIgniter\Database\Seeder;
//migrate xlsx to database
class ClubExcelSeed extends Seeder
{
    public function run()
    {
        ClubModel::import('dataeskul.xlsx');
    }
}
