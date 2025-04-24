<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\order;
use App\Models\stock;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $transactionableTypes = [
            order::class,
            stock::class,
        ];

        $type = fake()->randomElement($transactionableTypes);
        $model = $type::factory()->create();

        return [
            'transactionel_type' => $type,
            'transactionel_id' => $model->id,
            'operation' => fake()->randomElement(['created', 'updated', 'deleted']),
        ];
    }
}
