<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialistController extends Controller
{
    public function store(Request $request): array
    {
        $rules = array(
            'specialist_name.*'  => 'required|string|unique:specialists,name',
            'specialist_image.*'  => 'required',
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json([
                'error'  => $error->errors()->all()
            ]);
        }
        $specialist_names = $request->specialist_name;
        for($i = 0, $iMax = count($specialist_names); $i < $iMax; $i++)
        {
            $img = $request->file('specialist_image')[$i];
            $img_file =  $img->getClientOriginalName();
            $img->move("specialist/",$img_file);
            $path = 'specialist/' . $img_file;

            $data = array(
                'name'=> $request->specialist_name[$i],
                'image_path'=> $path,

            );

            $insert_data[] = $data;
        }
        Specialist::insert($insert_data);

        return [
            'success' => 'Specialists successfully created.',
            'url' => route('admin.specialists.index')
        ];
    }
    public function specialityForm()
    {
        return view('admin.specialist.partials.specialityForm');
    }
}
