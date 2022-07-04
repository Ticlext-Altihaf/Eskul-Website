<?php
namespace App\Models;

use Aspera\Spreadsheet\XLSX\Reader;
use CodeIgniter\Model;
use Exception;
use Faker\Generator;

class ClubModel extends Model
{
    protected $table = 'clubs';
    protected $primaryKey = 'name';
    public $allowedFields = [
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
    ];
    public static array $timetables = [
        'senin',
        'selasa',
        'rabu',
        'kamis',
    ];
    /*
    protected $validationRules = [
        'name' => 'required|is_unique[clubs.name]|trim|strtolower|alpha_numeric',
        'display_name' => 'required|trim|alpha_numeric_spaces',
        'coach_name' => 'required|trim|alpha_numeric_spaces',
        'chairman_name' => 'required|trim|alpha_numeric_spaces',
        'vice_chairman_name' => 'required|trim|alpha_numeric_spaces',
        'timetable' => 'required|in_list[senin, selasa, rabu, kamis]',
        'vision' => 'required|trim|alpha_numeric_spaces',
        'mission' => 'required|trim|alpha_numeric_spaces',
        'work_program' => 'required|trim|alpha_numeric_spaces',
        'icon' => 'required|alpha_numeric_spaces',
    ];
    */

    public static function make_forge(&$forge){
        $forge->addField([
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
                'null' => false,
            ],
            'display_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'coach_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'chairman_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'vice_chairman_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'timetable' => [
                'type' => 'enum',
                'constraint' => '"senin","selasa","rabu","kamis"',
            ],
            'vision' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'mission' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'work_program' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'instagram' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);

        $forge->addKey('name', TRUE);
        $forge->createTable('clubs');
    }
    public static function destroy_forge(&$forge){
        $forge->dropTable('clubs');
    }

    public static function display_name_to_id($display_name){
        //check if string
        if($display_name == '' || !is_string($display_name)){
            return null;
        }
        $display_name = str_replace(' ', '-' , strtolower($display_name));
        $display_name = preg_replace('/[^A-Za-z\d\-]/', '-', $display_name);
        //check if end with -
        if(substr($display_name, -1) == '-'){
            $display_name = substr($display_name, 0, -1);
        }
        //replace -- or more with -
        $display_name = preg_replace('/-{2,}/', '-', $display_name);
        return $display_name;
    }

    public function fake(Generator &$faker)
    {

        $image_url = $faker->imageUrl(1920, 1080);
        $ext = pathinfo($image_url, PATHINFO_EXTENSION);
        $name = $faker->unique()->sentence(4);
        $name_id = self::display_name_to_id($name);

        //download to images/icon/

        $image_name = $name_id.'.'.$ext;

        $image_path = 'images/icon/'.$image_name;
        $image_path = $image_url;

        return [
            'name' => $name_id,
            'display_name' => $name,
            'coach_name' => $faker->name,
            'chairman_name' => $faker->name,
            'vice_chairman_name' => $faker->name,
            'timetable' => $faker->randomElement(['senin', 'selasa', 'rabu', 'kamis']),
            'vision' => $faker->paragraph(5),
            'mission' => $faker->paragraph(5),
            'work_program' => $faker->userName,
            'icon' => $image_path,
            'instagram' => $name_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ];
    }

    /**
     * @throws \ReflectionException
     */
    public static function import($file)
    {
        $data = array();
        $reader = new Reader();
        $reader->open($file);
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
                    throw new Exception("Header XLSX harus: \"" . implode('", "', $actual_first_line) . "\"");
                }
            } else {
                $data[] = $row;
            }
        }
        $clubModel = model('App\Models\ClubModel');

        foreach ($data as $index => $row) {
            if(count($row) != count($actual_first_line)){
                print_r("Row " . $index . " is not correct: " . count($row) . " != " . count($actual_first_line));
                echo "\n";
                continue;
            }
            $row[1] = trim($row[1]);
            //replace non-alphanumeric character with '-'

            $name_id = ClubModel::display_name_to_id($row[1]);

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