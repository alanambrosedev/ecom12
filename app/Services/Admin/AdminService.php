<?php

namespace App\Services\Admin;

class AdminService
{
    public function login($data)
    {
        if (auth()->guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            if (! empty($data['remember'])) {
                setcookie('email', $data['email'], time() + 3600);
                setcookie('password', $data['password'], time() + 3600);
            } else {
                setcookie('email', '');
                setcookie('password', '');
            }
            $loginStatus = 1;

        } else {
            $loginStatus = 0;
        }

        return $loginStatus;
    }
}
