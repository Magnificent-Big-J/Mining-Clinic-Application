<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Doctor;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show()
    {
        return view('admin.user.show');
    }
    public function update(UserUpdateRequest $request, User $user)
    {
        $request->updateUser($user);

        return redirect()->back();
    }
    public function index()
    {
        return view('admin.users.index');
    }
    public function createAdmins()
    {
        return view('admin.users.create_admins');
    }
    public function create()
    {
        $doctors = Doctor::all();
        return view('admin.users.create', compact('doctors'));
    }
    public function storeAdmins(AdminUserCreateRequest $request)
    {
        $request->createAdmin();

        return redirect()->route('admin.users.index');
    }
    public function edit(User $editUser)
    {
        return view('admin.user.edit', compact('editUser'));
    }
    public function destroy(User $deleteUser)
    {
        if ($deleteUser->isDoctor()) {
            if ($deleteUser->doctor->appointments->count()) {
                session()->flash('error', 'Doctor user cannot be deleted.');
            } else {
                session()->flash('success', 'Doctor user is successfully deleted.');
            }
        } else {
            $deleteUser->delete();
            session()->flash('success', 'Admin user is successfully deleted.');
        }

        return redirect()->back();
    }
}
