<?php

namespace Database\Factories\Masters;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Masters\Unit>
 */
class UnitFactory extends Factory
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
            'name' => '部位名称'. sprintf('%04d', self::$sequence),
            'code' => 'UC_'. sprintf('%04d', self::$sequence++),
            'x_length' => $this->faker->numberBetween(5,20),
            'y_length' => $this->faker->numberBetween(5,20),
        ];
    }
}
