<?php

namespace Database\Seeders;

use App\Models\Masters\Category;
use App\Models\Masters\Inspection;
use App\Models\Masters\Item;
use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use App\Models\Masters\Unit;
use App\Models\Transactions\RecordedProduct;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        // カテゴリ生成
        Category::factory()->count(3)->create();

        //工程生成
        $phases = Phase::factory()->count(4)->state(new Sequence(
            ['name'=> 'マッピングA'],
            ['name'=> 'マッピングB'],
            ['name'=> 'チェックリスト'],
            ['name'=> '最終検査'],
        ))->create();

        //部位生成
        $units = Unit::factory()->count(5)->create();

        //品目生成
        $products = Product::factory()->count(3)->create();
        //品目ごとの仕様カテゴリ生成
        $products->each(function($product){
            Category::factory()->create([
                'name' => $product->name. '_仕様',
                'code' => $product->code. '_specifications',
                'form' => 'CHECKLIST'
            ]);
        });
        // 品目ごとに中間テーブル生成
        $products->each(function($product) use($phases, $units){
            // 品目部位
            $product->units()->sync($units->pluck('id'));
            // 検査（工程品目）
            $product->phases()->sync($phases->pluck('id'));
        });

        //項目生成
        $mappingItems = Item::factory()->count(20)->isMappingItem()->create();
        $checkingItems = Item::factory()->count(10)->isCheckingItem()->create();

        //カテゴリに割当て（マッピング）
        $mappingCategories = Category::where('form', 'MAPPING')->get();
        $mappingCategories->each(function ($category) use($mappingItems){
            $category->items()->sync($mappingItems->random(15)->pluck('id'));
        });

        //カテゴリに割当て（チェックリスト）
        $checkingCategories = Category::where('form', 'CHECKLIST')->where('is_by_recorded_product', false)->get();
        $checkingCategories->each(function ($category) use($checkingItems){
            $category->items()->sync($checkingItems->random(8)->pluck('id'));
        });

        // ここからトランザクション系
        // 品目ごとに製造実績
        $products->each(function($product){
            RecordedProduct::factory()->for($product)->count(5)->create();
        });
    }
}
