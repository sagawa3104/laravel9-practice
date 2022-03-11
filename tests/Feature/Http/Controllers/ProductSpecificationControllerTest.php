<?php

use App\Models\Masters\Product;
use App\Models\Masters\Specification;
use Illuminate\Database\Eloquent\Collection;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);


test('品目管理 仕様割当て画面', function () {
    // Arrange
    $product = Product::factory()->create();

    // Act
    $res = $this->get("/products/{$product->id}/attach-specifications");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('product', function($viewProduct) use($product){
        expect($viewProduct)->id->toBe($product->id);
        return $viewProduct instanceof Product;
    });
    $res->assertViewHas('specifications', function($viewSpecifications){
        return $viewSpecifications instanceof Collection;
    });
});

test('品目管理 仕様割当て適用 正常(全選択)', function () {
    // Arrange
    $product = Product::factory()->create();
    $specifications = Specification::factory()->count(3)->create();
    expect($product)->specifications->toHaveCount(0);
    $data = [
        'all' => ['select' => '1'],
    ];
    // Act
    $res = $this->from("/products/{$product->id}/attach-specifications")->put("/products/{$product->id}/attach-specifications", $data);
    $product->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/products');
    // DBが更新されていること
    expect($product)->specifications->toHaveCount($specifications->count());

});

test('品目管理 仕様割当て適用 正常(全解除)', function () {
    // Arrange
    $specifications = Specification::factory()->count(5)->create();
    $presetSpecifications = $specifications->take(3);
    $product = Product::factory()->hasAttached($presetSpecifications)->create();
    expect($product)->specifications->toHaveCount($presetSpecifications->count());
    $data = [
        'all' => ['release' => '1'],
    ];
    // Act
    $res = $this->from("/products/{$product->id}/attach-specifications")->put("/products/{$product->id}/attach-specifications", $data);
    $product->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/products');
    // DBが更新されていること
    expect($product)->specifications->toHaveCount(0);
});

test('品目管理 仕様割当て適用 正常3', function () {
    // Arrange
    $specifications = Specification::factory()->count(5)->create();
    $presetSpecifications = $specifications->take(3);
    $resetSpecifications = $specifications->take(-2);
    $product = Product::factory()->hasAttached($presetSpecifications)->create();
    // 最初に紐づけた分の仕様の数・内容を検証
    expect($product)->specifications->toHaveCount($presetSpecifications->count());
    expect($presetSpecifications)->each(function($specification) use($product){
        return $this->assertTrue($product->specifications->contains($specification->value));
    });
    $data = [
        'specifications' => $resetSpecifications->pluck('id'),
    ];
    // Act
    $res = $this->from("/products/{$product->id}/attach-specifications")->put("/products/{$product->id}/attach-specifications", $data);
    $product->refresh();

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/products');
    // 最初に紐づけた分は解除されていることを検証
    expect($presetSpecifications)->each(function($specification) use($product){
        return $this->assertFalse($product->specifications->contains($specification->value));
    });
    // 処理によって紐づけた分の仕様の数・内容を検証
    expect($product)->specifications->toHaveCount($resetSpecifications->count());
    expect($resetSpecifications)->each(function($specification) use($product){
        return $this->assertTrue($product->specifications->contains($specification->value));
    });

});

test('品目管理 仕様割当て適用 異常', function () {
    // Arrange
    $specifications = Specification::factory()->count(5)->create();
    $presetSpecifications = $specifications->take(3);
    $product = Product::factory()->hasAttached($presetSpecifications)->create();
    // 最初に紐づけた分の仕様の数・内容を検証
    expect($product)->specifications->toHaveCount($presetSpecifications->count());
    expect($presetSpecifications)->each(function($specification) use($product){
        return $this->assertTrue($product->specifications->contains($specification->value));
    });
    $data = [
        'specifications' => ['999'],
    ];
    // Act
    $res = $this->from("/products/{$product->id}/attach-specifications")->put("/products/{$product->id}/attach-specifications", $data);
    $product->refresh();

    // Assert
    // 自画面に戻ってきていること
    $res->assertRedirect("/products/{$product->id}/attach-specifications");
    // 紐づけたが変更されていないこと
    expect($product)->specifications->toHaveCount($presetSpecifications->count());
    expect($presetSpecifications)->each(function($specification) use($product){
        return $this->assertTrue($product->specifications->contains($specification->value));
    });

});


