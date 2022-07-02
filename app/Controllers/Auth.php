<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Session\Session;
use Config\Services;

class Auth extends BaseController
{
    public function login()
    {

        $data = array(
            'error' => null,
            'redirect_url' => $this->request->getCookie('redirect_url') ?? "/",
        );

        // Check if this form is submitted
        if ($this->request->getPost()) {
            $throttler = Services::throttler();

            // Restrict an IP address to no more than 1 request
            // 5 second across the entire site.
            if ($throttler->check(md5($this->request->getIPAddress()), 12, MINUTE) === false) {
                return Services::response()->setStatusCode(429);
            }

            //check if this browser
            // Get the user's credentials from the form
            $credentials = [
                'username' => $this->request->getPost('username'),
                'password' => $this->request->getPost('password'),
            ];
            $adminModel = model('App\Models\Admin');
            //check if exist
            $admin = $adminModel->where('username', $credentials['username'])->first();
            //check is default admin account exists
            if($credentials['username'] == 'root' && $admin == null){
                //add default admin account
                //todo change in production
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
                    // Redirect to previous page
                    return redirect()->to($data['redirect_url']);
                }else{
                    $data['error'] = 'Username atau Password salah';
                }
            }
            // Set the error message

        }
        return view('auth/login', $data);
    }

    public function logout(){
        $session = Services::session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }

}
