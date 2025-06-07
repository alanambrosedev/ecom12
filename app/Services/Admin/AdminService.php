<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

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

    public function updateDetails(array $data)
    {
        $imageName = '';

        if (request()->hasFile('image')) {
            $imageTmp = request()->file('image');

            if ($imageTmp->isValid()) {
                $manager = new ImageManager(new Driver);
                $image = $manager->read($imageTmp);

                $extension = $imageTmp->getClientOriginalExtension();
                $imageName = rand(111, 99999).'.'.$extension;
                $imagePath = public_path('admin/images/photos/'.$imageName);

                $image->save($imagePath);
            }
        } elseif (! empty($data['current_image'])) {
            $imageName = $data['current_image'];
        }

        Admin::where('email', auth()->guard('admin')->user()->email)
            ->update([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'image' => $imageName,
            ]);
    }

    public function deleteProfileImage($adminId)
    {
        $admin = Admin::find($adminId);

        if ($admin && $admin->image) {
            $profileImagePath = public_path('admin/images/photos/'.$admin->image);

            if (File::exists($profileImagePath)) {
                unlink($profileImagePath);
            }

            $admin->update(['image' => null]);

            return [
                'success' => true,
                'message' => 'Profile image deleted successfully.',
            ];
        }

        return [
            'success' => false,
            'message' => 'Profile image not found or admin not found.',
        ];
    }
}
