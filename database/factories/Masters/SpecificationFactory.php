<?php

namespace Database\Factories\Masters;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Masters\Specification>
 */
class SpecificationFactory extends Factory
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
            'name' => '仕様名称'. sprintf('%04d', self::$sequence),
            'code' => 'SC_'. sprintf('%04d', self::$sequence++),
            'is_checking_item' => $bool,
            'is_mapping_item' => !$bool,
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
