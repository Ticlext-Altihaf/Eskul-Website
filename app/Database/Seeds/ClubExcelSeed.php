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
        $data = array();
        $reader = new Reader();

        $reader->open('dataeskul.xlsx');
        $firstLine = null;
        $actual_first_line = array (
            0 => 'Timestamp',
            1 => 'nama ekstrakurikuler & organisasi',
            2 => 'nama lengkap pembina beserta gelar',
            3 => 'nama lengkap ketua',
            4 => 'nama lengkap wakil ketua',
            5 => 'jadwal kumpulan eskul & organisasi',
            6 => 'visi eskul & organisasi',
            7 => 'misi eskul & organisasi',
            8 => 'program kerja',
            9 => 'logo ekstrakurikuler & organisasi',
            10 => 'nama akun instagram eskul & organisasi',
        );
        foreach ($reader as $row) {
            if ($firstLine == null) {
                $firstLine = $row;
                //check firstLine with actual firstLine
                if ($firstLine != $actual_first_line) {
                    throw new Exception("First line is not correct: " . var_dump($firstLine) . " != " . var_dump($actual_first_line));
                }
            } else {
                $data[] = $row;
            }
        }
        $clubModel = model('App\Models\ClubModel');
        /*
         'name',//lowercase for id
        'display_name',//nama organisasi
        'coach_name',//nama pembina
        'chairman_name',//nama pimpinan
        'vice_chairman_name',//nama wakil pimpinan
        'timetable',//jadwal kegiatan (jumat dan ...)
        'vision',//visi
        'mission',//misi
        'work_program',//program kerja
        'icon',//icon organisasi (data:image/png;base64) or src="data here"
        'instagram',//instagram
        'created_at',
        'updated_at'
         */

        foreach ($data as $index => $row) {
            if(count($row) != count($actual_first_line)){
                print_r("Row " . $index . " is not correct: " . count($row) . " != " . count($actual_first_line));
                echo "\n";
                continue;
            }
            $name_id = ClubModel::display_name_to_id($row[1]);
            if($name_id == null){
                print_r("Index " . $index . ": name is not valid");
                echo "\n";
                continue;
            }
            //check if name is already in database
            $club = $clubModel->where('name', $name_id)->first();
            //exists ? get created_at
            $created_at = $club != null ? $club['created_at'] : $row[0];
            $updated_at = $row[0];
            $instagram = $row[10];
            //check if start with @
            if(strpos($instagram, '@') === 0){
                //remove it
                $instagram = substr($instagram, 1);
            }
            $icon = $row[9];
            $icon = "/images/icon/" . $icon;
            $grr = [
                'name' => $name_id,
                'display_name' => $row[1],
                'coach_name' => $row[2],
                'chairman_name' => $row[3],
                'vice_chairman_name' => $row[4],
                'timetable' => $row[5],
                'vision' => $row[6],
                'mission' => $row[7],
                'work_program' => $row[8],
                'icon' => $icon,
                'instagram' => $instagram,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
            if($club == null){
                $clubModel->insert($grr);
            }else{
                $clubModel->update($grr, ['name' => $name_id]);
            }
        }
    }
}
