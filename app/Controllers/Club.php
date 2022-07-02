<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClubModel;

class Club extends BaseController
{
    public function index($name = null)
    {
        if($name == null){
            //redirect to index page
            return redirect()->to(base_url('/'));
        }
        $clubModel = model('App\Models\ClubModel');
        $data = $clubModel->find($name);
        if($data == null){
            //redirect to index page
            return redirect()->to(base_url('/'));
        }
        return view('club', $data);
    }
}
