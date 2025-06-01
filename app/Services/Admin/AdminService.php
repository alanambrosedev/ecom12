<?php

namespace App\Services\Admin;

class AdminService
{
    public function login($data)
    {
        if (auth()->guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $loginStatus = 1;
        } else {
            $loginStatus = 0;
        }

        return $loginStatus;
    }
}
