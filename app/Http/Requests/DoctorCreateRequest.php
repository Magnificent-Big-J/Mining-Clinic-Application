<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use App\Models\DoctorEntity;
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
            'entity_name' => 'required_if:has_entity,on|string|unique:doctor_entities',
            'entity_status' => 'required_if:has_entity,on|string',
            'practice_number' => 'required|string',
            'complex' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'suburb' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'city' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'reg_number' => 'required|string',
            'specialist_name' => 'required',
            'postal_code' => 'required|numeric',
            'street' => 'required',
        ];
    }
    public function createUser(): void
    {

        $path = null;
        if ($this->has('avatar')) {
            $img = $this->file('avatar');
            $img_file =  $img_file = preg_replace('/\s+/', '_', $img->getClientOriginalName());
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

        $this->createDoctor($user->id);
        $role = Role::findById(2);
        $user->assignRole([$role->id]);
    }
    private function createDoctor(int $id): void
    {
        $doctor = Doctor::create([
            'email' => $this->entity_email,
            'practice_number' => $this->practice_number,
            'vat_number' => $this->vat_number,
            'tele_number' => $this->tele_number,
            'fax_number' => $this->fax_number,
            'complex' => $this->complex,
            'suburb' => $this->suburb,
            'street' => $this->street,
            'city' => $this->city,
            'has_entity' => ($this->has_entity) ? Doctor::No_ENTITY_STATE : Doctor::No_ENTITY_STATE,
            'code' => $this->postal_code,
            'reg_number' => $this->reg_number,
            'user_id' => $id,
        ]);

        $doctor->specialists()->attach([$this->specialist_name]);
        if ($this->has_entity) {
            DoctorEntity::create([
               'entity_name' => $this->entity_name,
               'entity_status' => $this->entity_status,
                'doctor_id'=> $doctor->id
            ]);
        }
    }
}
