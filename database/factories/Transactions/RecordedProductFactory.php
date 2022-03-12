<?php

namespace Database\Factories\Transactions;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transactions\RecordedProduct>
 */
class RecordedProductFactory extends Factory
{
    private static $sequence = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => 'RPN_'. sprintf('%04d', self::$sequence++),
            'is_created_recorded_inspections' => false,
        ];
    }
}
