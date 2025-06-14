<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UserModel;


class AuthController extends BaseController
{

    protected $user;


    public function __construct()
    {
        helper('form');
        $this->user = new UserModel();
    }

    public function login()
{
    if ($this->request->getPost()) {
        $rules = [
            'username' => 'required|min_length[6]',
            'password' => 'required|min_length[7]|numeric',
        ];

        if ($this->validate($rules)) {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            $dataUser = $this->user->where(['username' => $username])->first(); //pasw 1234567

            if ($dataUser) {
               if (password_verify($password, $dataUser['password'])) {
                    session()->set([
                        'username'    => $dataUser['username'],
                        'role'        => $dataUser['role'],
                        'email'       => $dataUser['email'],
                        'isLoggedIn'  => TRUE,
                        'login_time'  => date('Y-m-d H:i:s') 
                    ]);


                    return redirect()->to(base_url('/'));
                } else {
                    session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('failed', $this->validator->listErrors());
            return redirect()->back();
        }
    }

    return view('v_login');
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function profile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

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
