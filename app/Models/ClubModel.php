<?php
namespace App\Models;

use CodeIgniter\Model;
use Faker\Generator;

class ClubModel extends Model
{
    protected $table = 'clubs';
    protected $primaryKey = 'name';
    protected $allowedFields = [
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
        return str_replace(' ', '-' , strtolower($display_name));
    }

    public function fake(Generator &$faker)
    {

        $ext = pathinfo($image_url, PATHINFO_EXTENSION);
        $name = $faker->unique()->sentence(4);
        $name_id = self::display_name_to_id($name);

        //download to images/icon/
        $image_url = $faker->image();
        $image_name = $name_id.'.'.$ext;
        $image_path = 'images/icon/'.$image_name;
        $image_data = file_get_contents($image_url);
        file_put_contents($image_path, $image_data);

        return [
            'name' => $name_id,
            'display_name' => $name,
            'coach_name' => $faker->name,
            'chairman_name' => $faker->name,
            'vice_chairman_name' => $faker->name,
            'timetable' => $faker->randomElement(['senin', 'selasa', 'rabu', 'kamis']),
            'vision' => $faker->sentence,
            'mission' => $faker->sentence,
            'work_program' => $faker->userName,
            'icon' => '/'. $image_path,
            'instagram' => '@'.$name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        ];
    }

}