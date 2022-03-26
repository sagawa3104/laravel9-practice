<?php

namespace Database\Factories\Transactions;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transactions\RecordedInspectionDetail>
 */
class RecordedInspectionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'inspected_result' => 'NG'
        ];
    }
}
