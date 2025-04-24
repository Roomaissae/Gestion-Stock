<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    protected $model = supplier::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            //'contact_name' => $this->faker->name, // Enlève ceci si la colonne n'existe pas
            //'contact_email' => $this->faker->email,
            //'contact_phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
        ];
    }
}
