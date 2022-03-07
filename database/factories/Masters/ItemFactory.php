<?php

namespace Database\Factories\Masters;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Masters\Item>
 */
class ItemFactory extends Factory
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
            'name' => '項目名称'. sprintf('%04d', self::$sequence),
            'code' => 'IC_'. sprintf('%04d', self::$sequence++),
            'is_checking_item' => $this->faker->boolean(),
            'is_mapping_item' => $this->faker->boolean(),
        ];
    }

    public function isCheckingItem()
    {
        return $this->state(function (array $attribute){
            return [
                'is_checking_item' => true,
                'is_mapping_item' => false,
            ];
        });
    }

    public function isMappingItem()
    {
        return $this->state(function (array $attribute){
            return [
                'is_checking_item' => false,
                'is_mapping_item' => true,
            ];
        });
    }

    public function isCheckingMappingItem()
    {
        return $this->state(function (array $attribute){
            return [
                'is_checking_item' => true,
                'is_mapping_item' => true,
            ];
        });
    }
}
