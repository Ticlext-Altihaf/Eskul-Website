<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;

class Auth extends BaseController
{
    public function login()
    {
        // Check if user is already logged in
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }
        $data = array(
            'error' => null,
        );
        // Check if this form is submitted
        if ($this->request->getPost()) {
            //check if this browser
            // Get the user's credentials from the form
            $credentials = [
                'username' => $this->request->getPost('username'),
                'password' => $this->request->getPost('password')
            ];
            $adminModel = model('App\Models\Admin');
            //check if exist
            $admin = $adminModel->where('username', $credentials['username'])->first();
            //check is default admin account exists
            if($credentials['username'] == 'root' && $admin == null){
                //add default admin account
                $admin = array(
                    'username' => 'root',
                    'password' => password_hash('IAmRoot', PASSWORD_DEFAULT),
                    'role' => 'admin',
                    'admin_club' => null,
                );
                $adminModel->insert($admin);
            }
            if ($admin) {
                // Check if the password is correct
                if (password_verify($credentials['password'], $admin['password'])) {


                    // Set the session data
                    session()->set([
                        'isLoggedIn' => true,
                        'name' => $admin['username'],
                        'role' => $admin['role'],
                        'admin_club' => $admin['admin_club']
                    ]);
                    // Redirect to the dashboard
                    return redirect()->to(base_url('/'));
                }
            }
            // Set the error message
           $data['error'] = 'Username atau Password salah';
        }
        return view('auth/login', $data);
    }

    public function logout(){
        $session = Services::session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }

}
