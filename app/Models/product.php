<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // Indiquer le bon nom de table

    protected $fillable = [  'id',
    'name',
    'description',
    'price',
    'category_id',
    'supplier_id'
];
    public function category()
    {
        return $this->belongsTo(Categorie::class, 'category_id');
    }
     /**
     * Get the products of the current order.
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'product_orders')
                    ->withTimestamps()
                    ->withPivot('quantity', 'price');
    }

    // Relation avec le fournisseur
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    /**
     * Get the supplier of the current product.
     */
    public function  stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }
}
