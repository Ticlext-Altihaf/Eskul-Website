<?php
namespace App\Models;

use CodeIgniter\Model;
use Faker\Generator;

class ContactModel extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'type',//whatsapp, facebook, instagram, twitter, linkedin, email, phone, address, website,
        'href',//http or +1-555-555-5555 or admin@localhost//not null
        'description'//Budi Santoso
    ];
    protected $validationRules = [
        'type' => 'required|in_list[whatsapp, facebook, instagram, twitter, linkedin, email, phone, address, website]',
        'href' => 'required',
        'description' => 'required',
    ];



    public function fake(Generator &$faker)
    {
        return [
            'type' => $faker->randomElement(['whatsapp', 'facebook', 'instagram', 'twitter', 'linkedin', 'email', 'phone', 'address', 'website']),
            'href' => $faker->randomElement(['http://www.google.com', '+1-555-555-5555', 'admin@localhost']),
            'description' => $faker->name,
        ];
    }
}