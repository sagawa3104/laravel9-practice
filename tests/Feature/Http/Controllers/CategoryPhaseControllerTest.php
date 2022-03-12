<?php

use App\Models\Masters\Phase;
use App\Models\Masters\Category;
use Illuminate\Database\Eloquent\Collection;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);


test('工程管理 カテゴリ割当て画面', function () {
    // Arrange
    $phase = Phase::factory()->create();

    // Act
    $res = $this->get("/phases/{$phase->id}/attach-categories");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('phase', function($viewPhase) use($phase){
        expect($viewPhase)->id->toBe($phase->id);
        return $viewPhase instanceof Phase;
    });
    $res->assertViewHas('categories', function($viewCategories){
        return $viewCategories instanceof Collection;
    });
});

test('工程管理 カテゴリ割当て適用 正常(全選択)', function () {
    // Arrange
    $phase = Phase::factory()->create();
    $categories = Category::factory()->count(3)->create();
    expect($phase)->categories->toHaveCount(0);
    $data = [
        'all' => ['select' => '1'],
    ];
    // Act
    $res = $this->from("/phases/{$phase->id}/attach-categories")->put("/phases/{$phase->id}/attach-categories", $data);
    $phase->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/phases');
    // DBが更新されていること
    expect($phase)->categories->toHaveCount($categories->count());

});

test('工程管理 カテゴリ割当て適用 正常(全解除)', function () {
    // Arrange
    $categories = Category::factory()->count(5)->create();
    $presetCategories = $categories->take(3);
    $phase = Phase::factory()->hasAttached($presetCategories)->create();
    expect($phase)->categories->toHaveCount($presetCategories->count());
    $data = [
        'all' => ['release' => '1'],
    ];
    // Act
    $res = $this->from("/phases/{$phase->id}/attach-categories")->put("/phases/{$phase->id}/attach-categories", $data);
    $phase->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/phases');
    // DBが更新されていること
    expect($phase)->categories->toHaveCount(0);
});

test('工程管理 カテゴリ割当て適用 正常3', function () {
    // Arrange
    $categories = Category::factory()->count(5)->create();
    $presetCategories = $categories->take(3);
    $resetCategories = $categories->take(-2);
    $phase = Phase::factory()->hasAttached($presetCategories)->create();
    // 最初に紐づけた分のカテゴリの数・内容を検証
    expect($phase)->categories->toHaveCount($presetCategories->count());
    expect($presetCategories)->each(function($category) use($phase){
        return $this->assertTrue($phase->categories->contains($category->value));
    });
    $data = [
        'categories' => $resetCategories->pluck('id'),
    ];
    // Act
    $res = $this->from("/phases/{$phase->id}/attach-categories")->put("/phases/{$phase->id}/attach-categories", $data);
    $phase->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/phases');
    // 最初に紐づけた分は解除されていることを検証
    expect($presetCategories)->each(function($category) use($phase){
        return $this->assertFalse($phase->categories->contains($category->value));
    });
    // 処理によって紐づけた分のカテゴリの数・内容を検証
    expect($phase)->categories->toHaveCount($resetCategories->count());
    expect($resetCategories)->each(function($category) use($phase){
        return $this->assertTrue($phase->categories->contains($category->value));
    });

});

test('工程管理 カテゴリ割当て適用 異常', function () {
    // Arrange
    $categories = Category::factory()->count(5)->create();
    $presetCategories = $categories->take(3);
    $phase = Phase::factory()->hasAttached($presetCategories)->create();
    // 最初に紐づけた分のカテゴリの数・内容を検証
    expect($phase)->categories->toHaveCount($presetCategories->count());
    expect($presetCategories)->each(function($category) use($phase){
        return $this->assertTrue($phase->categories->contains($category->value));
    });
    $data = [
        'categories' => ['999'],
    ];
    // Act
    $res = $this->from("/phases/{$phase->id}/attach-categories")->put("/phases/{$phase->id}/attach-categories", $data);
    $phase->refresh();

    // Assert
    // 自画面に戻ってきていること
    $res->assertRedirect("/phases/{$phase->id}/attach-categories");
    // 紐づけたが変更されていないこと
    expect($phase)->categories->toHaveCount($presetCategories->count());
    expect($presetCategories)->each(function($category) use($phase){
        return $this->assertTrue($phase->categories->contains($category->value));
    });

});


