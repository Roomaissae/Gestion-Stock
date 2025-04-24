<?php

namespace Database\Factories;

use App\Models\categorie;
use App\Models\product;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Supplier;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class; // S'assurer que c'est bien Product

    public function definition()
    {
        return [
            'category_id' => categorie::factory(),
            'supplier_id' => Supplier::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'picture' => fake()->imageUrl(640, 480),
        ];
    }
}
