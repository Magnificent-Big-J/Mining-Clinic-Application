<?php

namespace App\Http\Requests;

use App\Models\ProductStock;
use App\Service\DoctorProductService;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ProductStockCreateRequest extends FormRequest
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
            'product_quantity' => 'required|numeric',
            'stock_date' => 'required',
        ];
    }

    public function createStock($doctorProduct)
    {
        $doctorProduct->quantity += $this->product_quantity;

        if (DoctorProductService::stockCaptured($this->stock_date, $doctorProduct->id)) {

           /* $productStock = ProductStock::where('stock_date', '=', $this->stock_date)->get();
            if ($productStock[0]->stock_date->equalTo($doctorProduct->created_at) && $doctorProduct->quantity == $this->product_quantity) {
                $doctorProduct->save();
                $product = ProductStock::find($productStock->id);
                $product = $product->quantity;
                $product->save();
                return 'Stock Successfully created';
            }*/

            return 'Stock has been updated.';
        } else {
            $doctorProduct->save();
            ProductStock::create([
                'quantity' => $this->product_quantity,
                'stock_date' => Carbon::parse($this->stock_date),
                'doctor_product_id' => $doctorProduct->id
            ]);
            return 'Stock Successfully created';
        }
    }
}
