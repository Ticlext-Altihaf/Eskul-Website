<?php

namespace App\Controllers;

use Aspera\Spreadsheet\XLSX\Reader;
use CodeIgniter\API\ResponseTrait;
use Exception;

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
    use ResponseTrait;

    public function api(): \CodeIgniter\HTTP\Response
    {
        //get session role
        $role = session()->get('role');
        //check if role is admin
        if (\App\Models\Admin::get_role_cardinality($role) != 1) {
            //redirect to index page
            return $this->respond(array(
                'message' => 'You are not authorized',
            ), 401);
        }

        //get data from request
        $action = $this->request->getVar('action');

        $adminModel = model('App\Models\Admin');
        if ($action == "delete") {
            if(!$this->validate([
                'username' => 'required',
            ])){
                return $this->respond(array(
                    'message' => 'Username is required',
                ), 400);
            }
            $username = $this->request->getVar('username');

            try {
                $adminModel->where('username', $username)->delete();
                $data['message'] = "Successfully deleted";
            } catch (Exception $e) {
                $data['error'] = $e->getMessage();
            }


        } elseif ($action == "add") {
            if(!$this->validate([
                'username' => 'required|min_length[3]|max_length[20]',
                'password' => 'required|min_length[3]|max_length[20]',
                'role' => 'required',
            ])){
                return $this->respond(array(
                    'message' => 'Invalid request',
                    'errors' => $this->validator->getErrors(),
                ), 400);
            }
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $role = $this->request->getVar('role');
            $admin_club = $this->request->getVar('admin_club');
            $admin = array(
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role,
                'admin_club' => $admin_club,
            );
            try {
                $a = $adminModel->insert($admin);
                $data['message'] = "Successfully added";
                $data['admin'] = $a;
            } catch (Exception $e) {
                $data['error'] = $e->getMessage();
            }
        } elseif ($action == "update") {

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $role = $this->request->getVar('role');
            $admin_club = $this->request->getVar('admin_club');
            if(!$this->validate([
                'username' => 'required|min_length[3]|max_length[20]',
            ])){
                return $this->respond(array(
                    'message' => 'Invalid request',
                    'errors' => $this->validator->getErrors(),
                ), 400);
            }
            $admin = array(
                'username' => $username
            );
            if ($password != null && $password != "") {
                $admin['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
            if ($role != null && $role != "") {
                $admin['role'] = $role;
                if(\App\Models\Admin::get_role_cardinality($role) == 5){
                    return $this->respond(array(
                        'message' => 'Not a valid role: '.$role,
                    ), 400);
                }
            }
            if ($admin_club != null && $admin_club != "") {
                $admin['admin_club'] = $admin_club;
                $club_model = model('App\Models\Club');
                $club = $club_model->where('club_id', $admin_club)->first();
                if($club == null){
                    return $this->respond(array(
                        'message' => 'Not a valid club: '.$admin_club,
                    ), 400);
                }
            }
            try {
                $adminModel->where('username', $username)->update($admin);
                $data['message'] = "Successfully updated";
            } catch (Exception $e) {
                $data['error'] = $e->getMessage();
            }
        }elseif ($action == "delete-all") {
            try {

                $data['message'] = "Successfully deleted";
            } catch (Exception $e) {
                $data['error'] = $e->getMessage();
            }
        } else{
            $data['error'] = "Unknown type";
        }
        $status = 200;
        if(isset($data['error'])){
            $data['message'] = $data['error'];
            $data['error'] = null;
            $status = 400;
        }
        return $this->respond($data, $status);//doesn't return with 200
    }

    public function delete($username)
    {
        //get session role
        $role = session()->get('role');
        //check if role is admin
        if (\App\Models\Admin::get_role_cardinality($role) != 1) {
            //redirect to index page
            return redirect()->to(base_url('/'));
        }
        $adminModel = model('App\Models\Admin');

        $adminModel->where('username', $username)->delete();
        return redirect()->back();
    }

    public function add(){
        //get session role
        $role = session()->get('role');
        //check if role is admin
        if (\App\Models\Admin::get_role_cardinality($role) != 1) {
            //redirect to index page
            return redirect()->to(base_url('/'));
        }
        if(!$this->validate([
            'username' => 'required|min_length[3]|max_length[20]',
            'password' => 'required|min_length[3]|max_length[20]',
            'role' => 'required',
        ])){
            return redirect()->with('errors', $this->validator->getErrors())->back();
        }
        $adminModel = model('App\Models\Admin');
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $role = $this->request->getVar('role');
        $admin_club = $this->request->getVar('admin_club');
        $admin = array(
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
            'admin_club' => $admin_club,
        );
        try {
            $a = $adminModel->insert($admin);
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->with('errors', array(
                'message' => $e->getMessage(),
            ))->back();
        }

    }

    public function auth()
    {
        //get session role
        $role = session()->get('role');
        //check if role is admin
        if (\App\Models\Admin::get_role_cardinality($role) != 1) {
            //redirect to index page
            return redirect()->to(base_url('/'));
        }
        $club_model = model('App\Models\ClubModel');
        $clubs = $club_model->findAll();
        $data = [
            'ip' => $this->request->getIPAddress(),
            'name' => session()->get('name'),
            'type' => "get",
            'error' => null,
            'roles' => \App\Models\Admin::$roles,
            'clubs' => $clubs,
        ];
        $adminModel = model('App\Models\Admin');

            //get query array
            $query = $this->request->getGet();
            $type = "get";
            if (isset($query['type'])) {
                $type = $query['type'];
            }
            if ($type) {
                $data['type'] = $type;
            }

            if ($type == "get") {
                $data['admins'] = $adminModel->findAll();
            }



        return view('admin/auth', $data);
    }


}
