<?php

namespace App\Exports;

use App\Service\ClinicProductService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class DoctorStockExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $range;
    protected $doctor;

    public function __construct($range, $doctor)
    {
        $this->range = $range;
        $this->doctor = $doctor;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ClinicProductService::getData($this->range, $this->doctor);
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
            $row->doctorProduct->product->product_code,
            $row->doctorProduct->product->productCategory->name,
            $row->doctorProduct->product->product_name,
            $row->doctorProduct->quantity,
            'R ' . $row->doctorProduct->price,
        ];
    }

    public function title(): string
    {
       return 'Doctor Stock Report between ' . $this->range[0] . ' and ' . $this->range[1];
    }
}
