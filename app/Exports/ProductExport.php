<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductExport implements FromCollection , WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'Product Code',
            'Product Category',
            'Product Name',
            'Product Description',
            'Product Size',
            'Product Unit',
        ];
    }

    public function map($product): array
    {
        return [
            $product->product_code,
            $product->productCategory->name,
            $product->product_name,
            $product->product_description,
            $product->product_size,
            $product->product_unit,
        ];
    }

    public function title(): string
    {
       return 'Products';
    }
}
