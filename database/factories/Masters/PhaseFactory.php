<?php

namespace Database\Factories\Masters;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Masters\Phase>
 */
class PhaseFactory extends Factory
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
            'name' => '工程名称'. sprintf('%04d', self::$sequence),
            'code' => 'PhC_'. sprintf('%04d', self::$sequence++),
        ];
    }
}
