<?php

namespace Database\Factories\Masters;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Masters\Product>
 */
class ProductFactory extends Factory
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
            'name' => '品目名称'. sprintf('%04d', self::$sequence),
            'code' => 'PrC_'. sprintf('%04d', self::$sequence++),
        ];
    }
}
