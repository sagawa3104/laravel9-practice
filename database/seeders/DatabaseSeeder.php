<?php

namespace Database\Seeders;

use App\Models\Masters\Category;
use App\Models\Masters\Item;
use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use App\Models\Masters\Specification;
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
        $categories = Category::factory()->count(3)->create();

        //工程生成
        $phases = Phase::factory()->count(4)->state(new Sequence(
            ['name'=> 'マッピングA'],
            ['name'=> 'マッピングB'],
            ['name'=> 'チェックリスト'],
            ['name'=> '最終検査'],
        ))->create();

        //部位生成
        $units = Unit::factory()->count(5)->create();

        //仕様生成
        $specifications = Specification::factory()->count(30)->create();
        // 項目生成
        $items = Item::factory()->count(30)->create();

        //品目生成
        $products = Product::factory()->count(3)->create();
        // 品目ごとに中間テーブル生成
        $products->each(function($product) use($phases, $units, $specifications){
            // 品目部位
            $product->units()->sync($units->pluck('id'));
            // 品目仕様
            $product->specifications()->sync($specifications->pluck('id'));
            // 検査（工程品目）
            $product->phases()->sync($phases->pluck('id'));
        });

        //カテゴリに割当て
        $categories->each(function(Category $category) use($phases, $specifications, $items){
            $category->phases()->sync($phases->pluck('id'));

            $category->isMappingThen(function($category) use($specifications, $items){
                $specificationIds = $specifications->where('is_mapping_item', true)->pluck('id');
                $itemIds = $items->where('is_mapping_item', true)->pluck('id');
                // 件数から-3した分だけランダムに登録
                $category->specifications()->sync($specificationIds->random($specificationIds->count()-3));
                $category->items()->sync($itemIds->random($itemIds->count()-3));
            });

            $category->isCheckingThen(function($category) use($specifications, $items){
                $specificationIds = $specifications->where('is_mapping_item', true)->pluck('id');
                $itemIds = $items->where('is_mapping_item', true)->pluck('id');
                // 件数から-3した分だけランダムに登録
                $category->specifications()->sync($specificationIds->random($specificationIds->count()-3));
                $category->items()->sync($itemIds->random($itemIds->count()-3));
            });
        });


        // ここからトランザクション系
        // 品目ごとに製造実績
        $products->each(function($product){
            $recordedProducts = RecordedProduct::factory()->for($product)->count(5)->create();
            $recordedProducts->each(function($recordedProduct){
                // 検査実績の生成
                $recordedProduct->createRecordedInspections();
                $recordedProduct->save();
            });
        });
    }
}
