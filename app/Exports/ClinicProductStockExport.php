<?php

namespace App\Exports;

use App\Models\Clinic;
use App\Models\ClinicProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ClinicProductStockExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    private $clinic;
    public function __construct(Clinic $clinic)
    {
        $this->clinic = $clinic;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ClinicProduct::where('clinic_id', '=', $this->clinic->id)->get();
    }

    public function headings(): array
    {
        return [
            'Product Code',
            'Product Category',
            'Product Name',
            'Product Quantity',
            'Product Price',

        ];
    }

    public function map($row): array
    {
        return [
            $row->product->product_code,
            $row->product->productCategory->name,
            $row->product->product_name,
            $row->quantity,
            'R ' . $row->price,
            $row->stock_date,
        ];
    }

    public function title(): string
    {


        return  "{$this->clinic->clinic_name} Product Stock ";
    }
}
