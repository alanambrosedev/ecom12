<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DetailRequest;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\PasswordRequest;
use App\Http\Requests\Admin\SubadminRequest;
use App\Models\Admin;
use App\Models\AdminRole;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'dashboard');

        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoginRequest $request)
    {
        $data = $request->validated();
        $loginStatus = $this->adminService->login($data);

        if ($loginStatus['success']) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->back()->with('error_message', $loginStatus['message']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        Session::put('page', 'update_password');

        return view('admin.update_password');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        auth()->guard('admin')->logout();

        return redirect()->route('admin.login');
    }

    public function verifyPassword(Request $request)
    {
        $data = $request->all();

        return $this->adminService->verifyPassword($data);
    }

    public function updatePassword(PasswordRequest $request)
    {
        $data = $request->validated();
        $response = $this->adminService->updatePassword($data);

        if ($response['status'] == 'success') {
            return redirect()->back()->with('success', $response['message']);
        } else {
            return redirect()->back()->with('error_message', $response['message']);
        }
    }

    public function editDetails()
    {
        Session::put('page', 'update-details');

        return view('admin.update_details');
    }

    /**
     * @param  \App\Http\Requests\DetailRequest  $request
     */
    public function updateDetails(DetailRequest $request)
    {
        Session::put('page', 'update_details');

        if ($request->isMethod('post')) {
            $this->adminService->updateDetails($request->validated());

            return redirect()->back()->with('success', 'Admin details updated successfully.');
        }
    }

    public function deleteProfileImage(Request $request)
    {
        $status = $this->adminService->deleteProfileImage($request->admin_id);

        return response()->json($status);
    }

    public function getSubadmins()
    {
        Session::put('page', 'subadmins');
        $subAdmins = $this->adminService->getSubadmins();

        return view('admin.subadmins.subadmins')->with(compact('subAdmins'));
    }

    public function UpdateSubadminStatus(Request $request)
    {
        $result = $this->adminService->UpdateSubadminStatus($request->id);

        if ($result['success']) {
            return response()->json(['status' => $result['status'], 'message' => $result['message']]);
        }

        return response()->json(['message' => $result['message'], 400]);
    }

    public function deleteSubadmin(Request $request)
    {
        $result = $this->adminService->deleteSubadmin($request->id);

        if ($result['success']) {
            return response()->json(['success' => true, 'message' => $result['message']]);
        } else {
            return response()->json(['success' => false, 'message' => $result['message']]);
        }
    }

    public function addEditSubadmin($id = null)
    {
        $title = $id ? 'Edit Subadmin' : 'Add Subadmin';
        $subadminDetails = $id ? Admin::findorFail($id) : null;

        return view('admin.subadmins.add-edit-subadmin', compact('title', 'subadminDetails'));
    }

    public function addEditSubadminSubmit(SubadminRequest $request)
    {
        $data = $request->validated();

        $this->adminService->addEditSubadmin($data);

        $message = isset($data['id']) ? 'Subadmin updated successfully.' : 'Subadmin added successfully.';

        return redirect()->route('admin.subadmins')->with('success', $message);
    }

    public function updateRole($id)
    {
        $admin = Admin::findOrFail($id);

        $modules = ['Categories', 'Products', 'Orders', 'Users', 'Subscribers'];

        $adminRoles = AdminRole::where('subadmin_id', $id)->get()->keyBy('module');

        return view('admin.subadmins.update_roles', compact('admin', 'modules', 'adminRoles'));
    }

    public function updateRoleRequest(Request $request, $id)
    {
        $modules = $request->input('modules', []);

        $this->adminService->UpdateSubadminRoles($id, $modules);

        return redirect()->back()->with('success', 'Subadmin roles updated successfully.');
    }
}
