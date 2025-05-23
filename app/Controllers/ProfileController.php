<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        // Ambil data dari session
        $data = [
            'username'    => session()->get('username'),
            'role'        => session()->get('role'),
            'email'       => session()->get('email'),
            'login_time'  => session()->get('login_time'),
            'isLoggedin'  => session()->get('isLoggedIn')
        ];

        return view('v_profile', $data); 
    }
}
