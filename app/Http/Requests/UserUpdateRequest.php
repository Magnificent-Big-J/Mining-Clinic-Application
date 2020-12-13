<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => 'required|string|unique:users,email,'. $this->user->id,

        ];
    }
    public function updateUser($user)
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
        $user->title = $this->title;
        $user->email = $this->email;
        $user->save();

        session()->flash('success','Information Successfully Updated');
    }
}
