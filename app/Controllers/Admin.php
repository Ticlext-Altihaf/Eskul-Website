<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Aspera\Spreadsheet\XLSX\Reader;
use Config\Pager;

class Admin extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Admin',
            'ip' => $this->request->getIPAddress(),
            'name' => session()->get('name'),
        ];
        $reader = new Reader();

            $reader->open('dataeskul.xlsx');
            $firstLine = null;
            foreach ($reader as $row) {
                if ($firstLine == null) {
                    $firstLine = $row;
                    $data['firstLine'] = $firstLine;
                } else {
                    $data['eskul'][] = $row;
                }
            }

        return view('admin/index', $data);
    }

    public function auth(){
        $data = [
            'ip' => $this->request->getIPAddress(),
            'name' => session()->get('name'),
            'type' => "get",
            'error' => null,
        ];
        $adminModel = model('App\Models\Admin');
        //check if post
        if($this->request->getPost()){
            $type = $this->request->getPost('type');
            if($type == "delete"){
                $username = $this->request->getPost('username');
                try {
                    $adminModel->where('username', $username)->delete();
                } catch (\Exception $e) {
                    $data['error'] = $e->getMessage();
                }
            }elseif ($type == "add") {
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');
                $role = $this->request->getPost('role');
                $admin_club = $this->request->getPost('admin_club');
                $admin = array(
                    'username' => $username,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => $role,
                    'admin_club' => $admin_club,
                );
                try {
                    $adminModel->insert($admin);
                } catch (\Exception $e) {
                    $data['error'] = $e->getMessage();

                }
            }elseif ($type == "update") {
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');
                $role = $this->request->getPost('role');
                $admin_club = $this->request->getPost('admin_club');
                $admin = array(
                    'username' => $username
                );
                if($password != ""){
                    $admin['password'] = password_hash($password, PASSWORD_DEFAULT);
                }
                if($role != ""){
                    $admin['role'] = $role;
                }
                if($admin_club != ""){
                    $admin['admin_club'] = $admin_club;
                }
                try {
                    $adminModel->where('username', $username)->update($admin);
                } catch (\Exception $e) {
                    $data['error'] = $e->getMessage();
                }
            }
        }else {
                //get query array
                $query = $this->request->getGet();
                $type = $query['type'];
                if ($type) {
                    $data['type'] = $type;
                }

                if ($type == "get") {
                    $data['admins'] = $adminModel->findAll();
                }
            }

       
        return view('admin/auth', $data);
    }
}
