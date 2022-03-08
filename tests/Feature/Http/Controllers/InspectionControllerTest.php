<?php

use App\Models\Masters\Product;
use App\Models\Masters\Phase;
use Illuminate\Database\Eloquent\Collection;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);


test('品目管理 工程割当て画面', function () {
    // Arrange
    $product = Product::factory()->create();

    // Act
    $res = $this->get("/products/{$product->id}/attach-phases");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('product', function($viewProduct) use($product){
        expect($viewProduct)->id->toBe($product->id);
        return $viewProduct instanceof Product;
    });
    $res->assertViewHas('phases', function($viewPhases){
        return $viewPhases instanceof Collection;
    });
});

test('品目管理 工程割当て適用 正常(全選択)', function () {
    // Arrange
    $product = Product::factory()->create();
    $phases = Phase::factory()->count(3)->create();
    expect($product)->phases->toHaveCount(0);
    $data = [
        'all' => ['select' => '1'],
    ];
    // Act
    $res = $this->from("/products/{$product->id}/attach-phases")->put("/products/{$product->id}/attach-phases", $data);
    $product->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/products');
    // DBが更新されていること
    expect($product)->phases->toHaveCount($phases->count());

});

test('品目管理 工程割当て適用 正常(全解除)', function () {
    // Arrange
    $phases = Phase::factory()->count(5)->create();
    $presetPhases = $phases->take(3);
    $product = Product::factory()->hasAttached($presetPhases)->create();
    expect($product)->phases->toHaveCount($presetPhases->count());
    $data = [
        'all' => ['release' => '1'],
    ];
    // Act
    $res = $this->from("/products/{$product->id}/attach-phases")->put("/products/{$product->id}/attach-phases", $data);
    $product->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/products');
    // DBが更新されていること
    expect($product)->phases->toHaveCount(0);
});

test('品目管理 工程割当て適用 正常3', function () {
    // Arrange
    $phases = Phase::factory()->count(5)->create();
    $presetPhases = $phases->take(3);
    $resetPhases = $phases->take(-2);
    $product = Product::factory()->hasAttached($presetPhases)->create();
    // 最初に紐づけた分の工程の数・内容を検証
    expect($product)->phases->toHaveCount($presetPhases->count());
    expect($presetPhases)->each(function($phase) use($product){
        return $this->assertTrue($product->phases->contains($phase->value));
    });
    $data = [
        'phases' => $resetPhases->pluck('id'),
    ];
    // Act
    $res = $this->from("/products/{$product->id}/attach-phases")->put("/products/{$product->id}/attach-phases", $data);
    $product->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/products');
    // 最初に紐づけた分は解除されていることを検証
    expect($presetPhases)->each(function($phase) use($product){
        return $this->assertFalse($product->phases->contains($phase->value));
    });
    // 処理によって紐づけた分の工程の数・内容を検証
    expect($product)->phases->toHaveCount($resetPhases->count());
    expect($resetPhases)->each(function($phase) use($product){
        return $this->assertTrue($product->phases->contains($phase->value));
    });

});

test('品目管理 工程割当て適用 異常', function () {
    // Arrange
    $phases = Phase::factory()->count(5)->create();
    $presetPhases = $phases->take(3);
    $product = Product::factory()->hasAttached($presetPhases)->create();
    // 最初に紐づけた分の工程の数・内容を検証
    expect($product)->phases->toHaveCount($presetPhases->count());
    expect($presetPhases)->each(function($phase) use($product){
        return $this->assertTrue($product->phases->contains($phase->value));
    });
    $data = [
        'phases' => ['999'],
    ];
    // Act
    $res = $this->from("/products/{$product->id}/attach-phases")->put("/products/{$product->id}/attach-phases", $data);
    $product->refresh();

    // Assert
    // 自画面に戻ってきていること
    $res->assertRedirect("/products/{$product->id}/attach-phases");
    // 紐づけたが変更されていないこと
    expect($product)->phases->toHaveCount($presetPhases->count());
    expect($presetPhases)->each(function($phase) use($product){
        return $this->assertTrue($product->phases->contains($phase->value));
    });

});


