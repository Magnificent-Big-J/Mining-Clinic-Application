<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultationCategoryUpdateRequest;
use App\Models\ConsultationCategory;

class ConsultationCategoryController extends Controller
{
    public function edit(ConsultationCategory $consultationCategory)
    {
        return $consultationCategory;
    }

    public function update(ConsultationCategoryUpdateRequest $request, ConsultationCategory $consultationCategory)
    {
        $request->updateConsultationCategory($consultationCategory);

        return [
            'message' => 'Category Successfully Updated'
        ];
    }
}
