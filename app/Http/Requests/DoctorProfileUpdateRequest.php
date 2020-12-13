<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorProfileUpdateRequest extends FormRequest
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
            'entity_name' => 'required|string|unique:doctors,entity_name,' . $this->user->doctor->id,
            'entity_status' => 'required|string',
            'email' => 'required|string',
            'practice_number' => 'required|string',
            'vat_number' => 'required',
            'address' => 'required|string',
            'reg_number' => 'required|string',
            'specialist_name' => 'required',
        ];
    }
    public function updateProfile($user)
    {
        $path = null;
        if ($this->has('avatar')) {
            $img = $this->file('avatar');
            $img_file =  $img->getClientOriginalName();
            $img->move("avatar/",$img_file);
            $path = 'avatar/' . $img_file;
            $user->avatar = $path;
        }

        if(!empty($this->password)) {
            $user->password = bcrypt($this->password);
        }

        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->save();

        $this->updateDoctor($user);
        session()->flash('success','Information Successfully Updated');
    }
    private function updateDoctor($user)
    {
        $user->doctor->specialists()->detach($this->specialist_name);
        $user->doctor->entity_name = $this->entity_name;
        $user->doctor->entity_status = $this->entity_status;
        $user->doctor->email = $this->email;
        $user->doctor->address = $this->address;
        $user->doctor->stock_scheme = $this->reg_number;
        $user->doctor->practice_number = $this->practice_number;
        $user->doctor->reg_number = $this->reg_number;
        $user->doctor->fax_number = $this->fax_number;
        $user->doctor->specialists()->attach($this->specialist_name);
        $user->doctor->save();
    }
}
