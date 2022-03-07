<?php

namespace Database\Factories\Masters;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Masters\Category>
 */
class CategoryFactory extends Factory
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
            'name' => 'カテゴリ名称'. sprintf('%04d', self::$sequence),
            'code' => 'CC_'. sprintf('%04d', self::$sequence++),
            'form' => 'MAPPING',
            'is_by_recorded_product' => false,
        ];
    }
}
