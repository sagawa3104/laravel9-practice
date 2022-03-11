<?php

use App\Models\Masters\Category;
use App\Models\Masters\Specification;
use Illuminate\Database\Eloquent\Collection;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);


test('カテゴリ管理 仕様割当て画面', function () {
    // Arrange
    $category = Category::factory()->create();

    // Act
    $res = $this->get("/categories/{$category->id}/attach-specifications");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('category', function($viewCategory) use($category){
        expect($viewCategory)->id->toBe($category->id);
        return $viewCategory instanceof Category;
    });
    $res->assertViewHas('specifications', function($viewSpecifications){
        return $viewSpecifications instanceof Collection;
    });
});

test('カテゴリ管理 仕様割当て適用 正常(全選択)', function () {
    // Arrange
    $category = Category::factory()->create();
    $specifications = Specification::factory()->count(3)->create();
    expect($category)->specifications->toHaveCount(0);
    $data = [
        'all' => ['select' => '1'],
    ];
    // Act
    $res = $this->from("/categories/{$category->id}/attach-specifications")->put("/categories/{$category->id}/attach-specifications", $data);
    $category->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/categories');
    // DBが更新されていること
    expect($category)->specifications->toHaveCount($specifications->count());

});

test('カテゴリ管理 仕様割当て適用 正常(全解除)', function () {
    // Arrange
    $specifications = Specification::factory()->count(5)->create();
    $presetSpecifications = $specifications->take(3);
    $category = Category::factory()->hasAttached($presetSpecifications)->create();
    expect($category)->specifications->toHaveCount($presetSpecifications->count());
    $data = [
        'all' => ['release' => '1'],
    ];
    // Act
    $res = $this->from("/categories/{$category->id}/attach-specifications")->put("/categories/{$category->id}/attach-specifications", $data);
    $category->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/categories');
    // DBが更新されていること
    expect($category)->specifications->toHaveCount(0);
});

test('カテゴリ管理 仕様割当て適用 正常3', function () {
    // Arrange
    $specifications = Specification::factory()->count(5)->create();
    $presetSpecifications = $specifications->take(3);
    $resetSpecifications = $specifications->take(-2);
    $category = Category::factory()->hasAttached($presetSpecifications)->create();
    // 最初に紐づけた分の仕様の数・内容を検証
    expect($category)->specifications->toHaveCount($presetSpecifications->count());
    expect($presetSpecifications)->each(function($specification) use($category){
        return $this->assertTrue($category->specifications->contains($specification->value));
    });
    $data = [
        'specifications' => $resetSpecifications->pluck('id'),
    ];
    // Act
    $res = $this->from("/categories/{$category->id}/attach-specifications")->put("/categories/{$category->id}/attach-specifications", $data);
    $category->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/categories');
    // 最初に紐づけた分は解除されていることを検証
    expect($presetSpecifications)->each(function($specification) use($category){
        return $this->assertFalse($category->specifications->contains($specification->value));
    });
    // 処理によって紐づけた分の仕様の数・内容を検証
    expect($category)->specifications->toHaveCount($resetSpecifications->count());
    expect($resetSpecifications)->each(function($specification) use($category){
        return $this->assertTrue($category->specifications->contains($specification->value));
    });

});

test('カテゴリ管理 仕様割当て適用 異常', function () {
    // Arrange
    $specifications = Specification::factory()->count(5)->create();
    $presetSpecifications = $specifications->take(3);
    $category = Category::factory()->hasAttached($presetSpecifications)->create();
    // 最初に紐づけた分の仕様の数・内容を検証
    expect($category)->specifications->toHaveCount($presetSpecifications->count());
    expect($presetSpecifications)->each(function($specification) use($category){
        return $this->assertTrue($category->specifications->contains($specification->value));
    });
    $data = [
        'specifications' => ['999'],
    ];
    // Act
    $res = $this->from("/categories/{$category->id}/attach-specifications")->put("/categories/{$category->id}/attach-specifications", $data);
    $category->refresh();

    // Assert
    // 自画面に戻ってきていること
    $res->assertRedirect("/categories/{$category->id}/attach-specifications");
    // 紐づけたが変更されていないこと
    expect($category)->specifications->toHaveCount($presetSpecifications->count());
    expect($presetSpecifications)->each(function($specification) use($category){
        return $this->assertTrue($category->specifications->contains($specification->value));
    });

});


