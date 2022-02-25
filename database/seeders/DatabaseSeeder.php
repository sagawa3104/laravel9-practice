<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //ユーザー生成
        User::factory()->state([
            'email' => 'test@example.com',
        ])->create();
        User::factory()->count(1)->unverified()->create();
    }
}
