<?php


namespace App\Service\Doctor;


use App\Models\Doctor;
use App\Models\DoctorEntity;
use App\User;
use Spatie\Permission\Models\Role;

class DoctorService
{
    public function createUser($request): void
    {

        $path = null;
        if ($request->has('avatar')) {
            $img = $request->file('avatar');
            $img_file =  $img_file = preg_replace('/\s+/', '_', $img->getClientOriginalName());
            $img->move("avatar/",$img_file);
            $path = 'avatar/' . $img_file;
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'title' => $request->title,
            'email' => $request->email,
            'password' => bcrypt('password'),
            'avatar' => $path
        ]);

        $this->createDoctor($user->id, $request);
        $role = Role::findById(2);
        $user->assignRole([$role->id]);
    }
    private function createDoctor(int $id, $request): void
    {
        $doctor = Doctor::create([
            'email' => $request->email,
            'practice_number' => $request->practice_number,
            'vat_number' => $request->vat_number,
            'tele_number' => $request->tele_number,
            'fax_number' => $request->fax_number,
            'complex' => $request->complex,
            'suburb' => $request->suburb,
            'city' => $request->city,
            'has_entity' => ($request->has_entity == 'on') ? Doctor::No_ENTITY_STATE : Doctor::No_ENTITY_STATE,
            'code' => $request->postal_code,
            'reg_number' => $request->reg_number,
            'user_id' => $id,
            'street' => $request->street,
        ]);

        $doctor->specialists()->attach($request->specialist_name);

        if ($request->has_entity) {
            DoctorEntity::create([
                'entity_name' => $request->entity_name,
                'entity_status' => $request->entity_status,
                'complex' => $request->complex,
                'suburb' => $request->suburb,
                'city' => $request->city,
                'code' => $request->postal_code,
                'doctor_id'=> $doctor->id
            ]);
        }
    }
    public function updateProfile($user, $request): void
    {
        $path = null;
        if ($request->has('avatar')) {
            $img = $request->file('avatar');
            $img_file =  $img_file = preg_replace('/\s+/', '_', $img->getClientOriginalName());
            $img->move("avatar/",$img_file);
            $path = 'avatar/' . $img_file;
            $user->avatar = $path;
        }

        if(!empty($this->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();

        $this->updateDoctor($user, $request);
        if ($user->doctor->has_entity === Doctor::HAS_ENTITY_STATE) {
            $this->updateEntity($user, $request);
        }

    }
    private function updateDoctor($user, $request): void
    {
        $user->doctor->specialists()->detach($request->specialist_name);
        $user->doctor->email = $request->email;
        $user->doctor->complex = $request->complex;
        $user->doctor->city = $request->city;
        $user->doctor->suburb = $request->suburb;
        $user->doctor->code = $request->postal_code;
        $user->doctor->practice_number = $request->practice_number;
        $user->doctor->reg_number = $request->reg_number;
        $user->doctor->fax_number = $request->fax_number;
        $user->doctor->specialists()->attach($request->specialist_name);
        $user->doctor->save();
    }
    private function updateEntity($user, $request): void
    {
        $user->doctor->doctorEntity->entity_name = $request->entity_name;
        $user->doctor->doctorEntity->entity_status = $request->entity_status;
        $user->doctor->doctorEntity->save();
    }

}
