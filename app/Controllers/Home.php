<?php

namespace App\Controllers;

use App\Models\ClubModel;

class Home extends BaseController
{
    public function index()
    {
        $clubModel = model('App\Models\ClubModel');
        $data['clubs'] = $clubModel->findAll();
        return view('welcome_message', $data);
    }
}
