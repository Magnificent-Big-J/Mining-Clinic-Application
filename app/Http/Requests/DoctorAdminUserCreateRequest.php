<?php

namespace App\Http\Requests;

use App\Mail\WelcomeEmail;
use App\Models\Admin;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class DoctorAdminUserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'title' => 'required|string',
            'email' => 'required|string|unique:users',
            'doctor' => 'required',
        ];
    }
    public function createDoctorAdmin()
    {
        $path = null;
        if ($this->has('avatar')) {
            $img = $this->file('avatar');
            $img_file = preg_replace('/\s+/', '_', $img->getClientOriginalName());
            $img->move("avatar/",$img_file);
            $path = 'avatar/' . $img_file;
        }

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'title' => $this->title,
            'email' => $this->email,
            'password' => bcrypt('password'),
            'avatar' => $path
        ]);
        session()->flash('success','User Successfully Created');
        $role = Role::findById(2);
        $user->assignRole([$role->id]);
        $admin = Admin::create(['user_id' => $user->id]);
        $admin->doctors()->attach([$this->doctor]);
        Mail::to($user->email)->send(new WelcomeEmail($user));
    }
}
