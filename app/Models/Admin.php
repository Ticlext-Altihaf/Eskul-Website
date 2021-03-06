<?php

namespace App\Models;

use CodeIgniter\Model;

class Admin extends Model
{


    protected $DBGroup = 'default';
    protected $table = 'admins';
    protected $primaryKey = 'username';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'username',
        'password',
        'role',
        'admin_club',//sub editor
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';


    // Validation
    protected $validationRules = [
        'username' => 'required',
        'password' => 'required',
        'role' => 'required',
    ];
public static array $roles = array(
'admin' => 1,
'editor' => 2,
'editor_club' => 3,
'guest' => 4,
);
    public static function get_role_cardinality($role):int
    {

        if(isset(Admin::$roles[$role])){
            return Admin::$roles[$role];
        }
        return 5;
    }
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];


}
