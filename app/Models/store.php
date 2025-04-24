<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class store extends Model
{
    use HasFactory;
    public function products()
    {
        return $this->hasManyThrough(Product::class, Stock::class);
    }
}
