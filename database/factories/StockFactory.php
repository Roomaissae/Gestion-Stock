<?php

namespace Database\Factories;

use App\Models\stock;
use App\Models\product;
use App\Models\store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    protected $model = stock::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'store_id' => store::factory(),
            'quantity_stock' => fake()->numberBetween(0, 1000),
        ];
    }
}
