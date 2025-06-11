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
            $admin = auth()->guard('admin')->user();

            if ($admin->status == 0) {
                auth()->guard('admin')->logout(); // Logout immediately

                return [
                    'success' => false,
                    'message' => 'Your account is inactive. Please contact administrator.',
                ];
            }

            // Remember me functionality
            if (! empty($data['remember'])) {
                setcookie('email', $data['email'], time() + 3600);
                setcookie('password', $data['password'], time() + 3600);
            } else {
                setcookie('email', '', time() - 3600);
                setcookie('password', '', time() - 3600);
            }

            return ['success' => true];
        }

        return [
            'success' => false,
            'message' => 'Invalid Email or Password. Please try again.',
        ];
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

    public function getSubadmins()
    {
        $subAdmins = Admin::where('role', 'subadmin')->get();

        return $subAdmins;
    }

    public function UpdateSubadminStatus($subadminId)
    {
        $subAdmin = Admin::find($subadminId);

        if ($subAdmin) {
            $subAdmin->status = $subAdmin->status == 1 ? 0 : 1;
            $subAdmin->save();

            return [
                'success' => true,
                'status' => $subAdmin->status,
                'message' => 'Subadmin status updated successfully.',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Subadmin not found.',
            ];
        }
    }

    public function deleteSubadmin($id)
    {
        $subAdmin = Admin::find($id);

        if (! $subAdmin) {
            return [
                'success' => false,
                'message' => 'Subadmin not found.',
            ];
        }

        if ($subAdmin->role != 'subadmin') {
            return [
                'success' => false,
                'message' => 'Cannot delete this subadmin.',
            ];
        }

        $subAdmin->delete();

        return [
            'success' => true,
            'message' => 'Subadmin deleted successfully.',
        ];
    }

    public function addEditSubadmin($data)
    {
        $admin = isset($data['id']) ? Admin::find($data['id']) : new Admin;

        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->mobile = $data['mobile'];

        if (! empty($data['password'])) {
            $admin->password = bcrypt($data['password']);
        }

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
                $admin->image = $imageName;
            }
        } elseif (! empty($data['current_image'])) {
            $admin->image = $data['current_image'];
        }

        $admin->role = 'subadmin';
        $admin->status = 1;
        $admin->save();
    }
}
