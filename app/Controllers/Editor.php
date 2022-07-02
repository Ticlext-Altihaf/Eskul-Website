<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Exception;
use Faker\Extension\Helper;

class Editor extends BaseController
{
    function isValidEditor($club): bool
    {

        $role = session()->get('role');
        //if editor or higher, return true
        $cardinal = \App\Models\Admin::get_role_cardinality($role);
        if ($cardinal < 3) {
            return True;
        }
        if($cardinal == 3){
            //if editor_club, check if club is the same
            if($club == session()->get('admin_club')){
                return True;
            }
        }
        return False;
    }
    //read only
    public function index()
    {

        $data = [
            'name' => session()->get('name'),
        ];
        $clubModel = model('App\Models\ClubModel');
        $data['clubs'] = $clubModel->findAll();
        $data["keys_field"] = $clubModel->allowedFields;
        return view('editor/index', $data);
    }

    public function delete($club_name)
    {
        if(!$this->isValidEditor($club_name)){
            //get previous url
            return view('editor/error', ['error' => 'You are not authorized to delete this club']);//TODO translate
        }
        $clubModel = model('App\Models\ClubModel');
        try {
            $clubModel->where('club_name', $club_name)->delete();
        } catch (Exception $e) {
        }
        #redirect to previous page
        return redirect()->to(previous_url());
    }

    public function add()
    {
        $role = session()->get('role');
        //if lower than editor, redirect to index page
        if (\App\Models\Admin::get_role_cardinality($role) > 2) {
            //redirect to index page
            return redirect()->to(base_url('/'));
        }
    }
}
