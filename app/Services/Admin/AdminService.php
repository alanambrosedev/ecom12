<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

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

    public function verifyPassword($data)
    {
        if (Hash::check($data['current_password'], auth()->guard('admin')->user()->password)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function updatePassword($data)
    {
        if (Hash::check($data['current_password'], auth()->guard('admin')->user()->password)) {
            if ($data['new_password'] == $data['confirm_password']) {
                Admin::where('email', auth()->guard('admin')->user()->email)->update(['password' => bcrypt($data['new_password'])]);
                $status = 'success';
                $message = 'Password updated successfully.';

            } else {
                $status = 'error';
                $message = 'New password and confirm password do not match.';
            }
        } else {
            $status = 'error';
            $message = 'Current password is incorrect.';
        }

        return [
            'status' => $status,
            'message' => $message,
        ];
    }

    public function updateDetails($data)
    {
        Admin::where('email', auth()->guard('admin')->user()->email)
            ->update([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
            ]);
    }
}
