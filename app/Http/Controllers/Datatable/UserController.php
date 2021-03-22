<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\User;
use DataTables;

class UserController extends Controller
{
    public function users()
    {
        $users = User::all();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('full_name', function ($row){
                return view('admin.users.partials.profile', compact('row'));
            })
            ->addColumn('edit', function ($row){
                return view('admin.users.partials.actions', compact('row'));
            })
            ->addColumn('delete', function ($row){
                return view('admin.users.partials.delete', compact('row'));
            })
            ->make(true);
    }
}
