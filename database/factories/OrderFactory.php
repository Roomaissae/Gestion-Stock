<?php

namespace Database\Factories;

use App\Models\order;
use App\Models\product;
use App\Models\customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = order::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'order_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $products = product::inRandomOrder()->take(3)->get(); // Ajoute 3 produits aléatoires à la commande
            $order->products()->attach($products->pluck('id'), [
                'quantity' => $this->faker->numberBetween(1, 5),
                'sale_price' => $this->faker->randomFloat(2, 1, 100),
            ]);
        });
    }
}
