<?php

use App\Models\Masters\Product;
use App\Models\Masters\Unit;
use Illuminate\Database\Eloquent\Collection;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);


test('品目管理 部位割当て画面', function () {
    // Arrange
    $product = Product::factory()->create();

    // Act
    $res = $this->get("/products/{$product->id}/attach-units");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('product', function($viewProduct) use($product){
        expect($viewProduct)->id->toBe($product->id);
        return $viewProduct instanceof Product;
    });
    $res->assertViewHas('units', function($viewUnits){
        return $viewUnits instanceof Collection;
    });
});

test('品目管理 部位割当て適用 正常(全選択)', function () {
    // Arrange
    $product = Product::factory()->create();
    $units = Unit::factory()->count(3)->create();
    expect($product)->units->toHaveCount(0);
    $data = [
        'all' => ['select' => '1'],
    ];
    // Act
    $res = $this->from("/products/{$product->id}/attach-units")->put("/products/{$product->id}/attach-units", $data);
    $product->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/products');
    // DBが更新されていること
    expect($product)->units->toHaveCount($units->count());

});

test('品目管理 部位割当て適用 正常(全解除)', function () {
    // Arrange
    $units = Unit::factory()->count(5)->create();
    $presetUnits = $units->take(3);
    $product = Product::factory()->hasAttached($presetUnits)->create();
    expect($product)->units->toHaveCount($presetUnits->count());
    $data = [
        'all' => ['release' => '1'],
    ];
    // Act
    $res = $this->from("/products/{$product->id}/attach-units")->put("/products/{$product->id}/attach-units", $data);
    $product->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/products');
    // DBが更新されていること
    expect($product)->units->toHaveCount(0);
});

test('品目管理 部位割当て適用 正常3', function () {
    // Arrange
    $units = Unit::factory()->count(5)->create();
    $presetUnits = $units->take(3);
    $resetUnits = $units->take(-2);
    $product = Product::factory()->hasAttached($presetUnits)->create();
    // 最初に紐づけた分の部位の数・内容を検証
    expect($product)->units->toHaveCount($presetUnits->count());
    expect($presetUnits)->each(function($unit) use($product){
        return $this->assertTrue($product->units->contains($unit->value));
    });
    $data = [
        'units' => $resetUnits->pluck('id'),
    ];
    // Act
    $res = $this->from("/products/{$product->id}/attach-units")->put("/products/{$product->id}/attach-units", $data);
    $product->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/products');
    // 最初に紐づけた分は解除されていることを検証
    expect($presetUnits)->each(function($unit) use($product){
        return $this->assertFalse($product->units->contains($unit->value));
    });
    // 処理によって紐づけた分の部位の数・内容を検証
    expect($product)->units->toHaveCount($resetUnits->count());
    expect($resetUnits)->each(function($unit) use($product){
        return $this->assertTrue($product->units->contains($unit->value));
    });

});

test('品目管理 部位割当て適用 異常', function () {
    // Arrange
    $units = Unit::factory()->count(5)->create();
    $presetUnits = $units->take(3);
    $product = Product::factory()->hasAttached($presetUnits)->create();
    // 最初に紐づけた分の部位の数・内容を検証
    expect($product)->units->toHaveCount($presetUnits->count());
    expect($presetUnits)->each(function($unit) use($product){
        return $this->assertTrue($product->units->contains($unit->value));
    });
    $data = [
        'units' => ['999'],
    ];
    // Act
    $res = $this->from("/products/{$product->id}/attach-units")->put("/products/{$product->id}/attach-units", $data);
    $product->refresh();

    // Assert
    // 自画面に戻ってきていること
    $res->assertRedirect("/products/{$product->id}/attach-units");
    // 紐づけたが変更されていないこと
    expect($product)->units->toHaveCount($presetUnits->count());
    expect($presetUnits)->each(function($unit) use($product){
        return $this->assertTrue($product->units->contains($unit->value));
    });

});


