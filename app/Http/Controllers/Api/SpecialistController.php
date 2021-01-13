<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialistCreateRequest;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
    public function store(Request $request): array
    {

        return $request->all();
        $request->createSpecialist();

        return [
            'message' => 'Specialists successfully updated.',
            'url' => route('admin.specialists.index')
        ];
    }
}
