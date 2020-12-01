<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

class DoctorCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'entity_name' => 'required|string|unique:doctors',
            'entity_status' => 'required|string',
            'entity_email' => 'required|string',
            'practice_number' => 'required|string',
            'vat_number' => 'required',
            'address' => 'required|string',
            'stock_scheme' => 'required|string',
            'reg_number' => 'required|string',
            'specialist_name' => 'required',
        ];
    }
    public function createUser()
    {

        $path = null;
        if ($this->has('avatar')) {
            $img = $this->file('avatar');
            $img_file =  $img->getClientOriginalName();
            $img->move("specialist/",$img_file);
            $path = 'specialist/' . $img_file;
        }

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'title' => $this->title,
            'email' => $this->email,
            'password' => bcrypt('password'),
            'avatar' => $path
        ]);

        $this->createDoctor($user->id);
        $role = Role::findById(2);
        $user->assignRole([$role->id]);
    }
    private function createDoctor(int $id)
    {
        $doctor = Doctor::create([
            'entity_name' => $this->entity_name,
            'entity_status' => $this->entity_status,
            'email' => $this->entity_email,
            'practice_number' => $this->practice_number,
            'vat_number' => $this->vat_number,
            'tele_number' => $this->tele_number,
            'fax_number' => $this->fax_number,
            'address' => $this->address,
            'stock_scheme' => $this->stock_scheme,
            'reg_number' => $this->reg_number,
            'user_id' => $id,
        ]);

        $doctor->specialists()->attach([$this->specialist_name]);
    }
}
