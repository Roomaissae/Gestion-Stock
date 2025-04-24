<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ProductExport implements FromCollection, WithCustomStartCell,WithHeadings
{
    public function collection()
    {
        return Product::join('categories', 'category_id','=' ,'categories.id')
        ->join('suppliers', 'supplier_id','=' ,'suppliers.id')
        ->select('products.id', 'products.name','products.description',  'price', "suppliers.name as supplier" , 'categories.name as category')
        ->get();
    }
    public function headings(): array
    {
        return ['id',
        'name',
        'description',
        'price',
        'category',
        'supplier'];
    }

    public function startCell(): string
    {
        return 'C5';
    }
}
