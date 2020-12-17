<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
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

        return redirect()->route('admin.user.profile');
    }
    public function index()
    {
        return view('admin.users.index');
    }
}
