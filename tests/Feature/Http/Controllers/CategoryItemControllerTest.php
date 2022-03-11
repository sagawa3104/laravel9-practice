<?php

use App\Models\Masters\Category;
use App\Models\Masters\Item;
use Illuminate\Database\Eloquent\Collection;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);


test('カテゴリ管理 項目割当て画面', function () {
    // Arrange
    $category = Category::factory()->create();

    // Act
    $res = $this->get("/categories/{$category->id}/attach-items");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('category', function($viewCategory) use($category){
        expect($viewCategory)->id->toBe($category->id);
        return $viewCategory instanceof Category;
    });
    $res->assertViewHas('items', function($viewItems){
        return $viewItems instanceof Collection;
    });
});

test('カテゴリ管理 項目割当て適用 正常(全選択)', function () {
    // Arrange
    $category = Category::factory()->create();
    $items = Item::factory()->count(3)->create();
    expect($category)->items->toHaveCount(0);
    $data = [
        'all' => ['select' => '1'],
    ];
    // Act
    $res = $this->from("/categories/{$category->id}/attach-items")->put("/categories/{$category->id}/attach-items", $data);
    $category->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/categories');
    // DBが更新されていること
    expect($category)->items->toHaveCount($items->count());

});

test('カテゴリ管理 項目割当て適用 正常(全解除)', function () {
    // Arrange
    $items = Item::factory()->count(5)->create();
    $presetItems = $items->take(3);
    $category = Category::factory()->hasAttached($presetItems)->create();
    expect($category)->items->toHaveCount($presetItems->count());
    $data = [
        'all' => ['release' => '1'],
    ];
    // Act
    $res = $this->from("/categories/{$category->id}/attach-items")->put("/categories/{$category->id}/attach-items", $data);
    $category->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/categories');
    // DBが更新されていること
    expect($category)->items->toHaveCount(0);
});

test('カテゴリ管理 項目割当て適用 正常3', function () {
    // Arrange
    $items = Item::factory()->count(5)->create();
    $presetItems = $items->take(3);
    $resetItems = $items->take(-2);
    $category = Category::factory()->hasAttached($presetItems)->create();
    // 最初に紐づけた分の項目の数・内容を検証
    expect($category)->items->toHaveCount($presetItems->count());
    expect($presetItems)->each(function($item) use($category){
        return $this->assertTrue($category->items->contains($item->value));
    });
    $data = [
        'items' => $resetItems->pluck('id'),
    ];
    // Act
    $res = $this->from("/categories/{$category->id}/attach-items")->put("/categories/{$category->id}/attach-items", $data);
    $category->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/categories');
    // 最初に紐づけた分は解除されていることを検証
    expect($presetItems)->each(function($item) use($category){
        return $this->assertFalse($category->items->contains($item->value));
    });
    // 処理によって紐づけた分の項目の数・内容を検証
    expect($category)->items->toHaveCount($resetItems->count());
    expect($resetItems)->each(function($item) use($category){
        return $this->assertTrue($category->items->contains($item->value));
    });

});

test('カテゴリ管理 項目割当て適用 異常', function () {
    // Arrange
    $items = Item::factory()->count(5)->create();
    $presetItems = $items->take(3);
    $category = Category::factory()->hasAttached($presetItems)->create();
    // 最初に紐づけた分の項目の数・内容を検証
    expect($category)->items->toHaveCount($presetItems->count());
    expect($presetItems)->each(function($item) use($category){
        return $this->assertTrue($category->items->contains($item->value));
    });
    $data = [
        'items' => ['999'],
    ];
    // Act
    $res = $this->from("/categories/{$category->id}/attach-items")->put("/categories/{$category->id}/attach-items", $data);
    $category->refresh();

    // Assert
    // 自画面に戻ってきていること
    $res->assertRedirect("/categories/{$category->id}/attach-items");
    // 紐づけたが変更されていないこと
    expect($category)->items->toHaveCount($presetItems->count());
    expect($presetItems)->each(function($item) use($category){
        return $this->assertTrue($category->items->contains($item->value));
    });

});


