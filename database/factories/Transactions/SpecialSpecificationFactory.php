<?php

namespace Database\Factories\Transactions;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transactions\SpecialSpecification>
 */
class SpecialSpecificationFactory extends Factory
{
    private static $sequence = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $bool = $this->faker->boolean();
        return [
            //
            'name' => '専用仕様'. sprintf('%04d', self::$sequence++),
            'is_checking_item' => $bool,
            'is_mapping_item' => !$bool,
        ];
    }
}
