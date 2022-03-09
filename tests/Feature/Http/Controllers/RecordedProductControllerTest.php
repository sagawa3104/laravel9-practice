<?php

use App\Models\Masters\Product;
use App\Models\Transactions\RecordedProduct;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Arrange
    $count = 16;
    Product::factory()->has(RecordedProduct::factory()->count($count))->create();
});

test('製造実績管理 一覧', function () {

    // Act
    $res = $this->get('/recorded-products');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('recordedProducts', function(Illuminate\Pagination\LengthAwarePaginator $viewRecordedProducts){
        return $viewRecordedProducts->lastPage() === 2;
    });
});

test('製造実績管理 登録画面', function () {
    // Arrange

    // Act
    $res = $this->get('/recorded-products/create');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

test('製造実績管理 登録処理_正常', function () {
    // Arrange
    $product = Product::first();
    $data = [
        'recorded_product_code' => 'test_code',
        'product' => (String)$product->id
    ];
    $this->assertDatabaseMissing('recorded_products', [
        'code' => $data['recorded_product_code'],
        'product_id' => $data['product'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/recorded-products/create')->post('/recorded-products', $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/recorded-products');
    // DBに登録されていること
    $this->assertDatabaseHas('recorded_products', [
        'code' => $data['recorded_product_code'],
        'product_id' => $product->id,
    ]);
});

test('製造実績管理 登録処理_異常(バリデーション)', function () {
    // Arrange
    $data = [
        'recorded_product_code' => 'test_code',
        'product' => ''
    ];
    $this->assertDatabaseMissing('recorded_products', [
        'code' => $data['recorded_product_code'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/recorded-products/create')->post('/recorded-products', $data);

    // Assert
    // 自画面をリダイレクトしていること
    $res->assertRedirect('/recorded-products/create');
    // DBに登録されていないこと
    $this->assertDatabaseMissing('recorded_products', [
        'code' => $data['recorded_product_code'],
    ]);
});

test('製造実績管理 更新画面', function () {
    // Arrange
    $recordedProduct = RecordedProduct::first();
    // Act
    $res = $this->get("/recorded-products/{$recordedProduct->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewHas('recordedProduct', function(RecordedProduct $viewRecordedProduct) use($recordedProduct){
        return $viewRecordedProduct->id === $recordedProduct->id;
    });
});

test('製造実績管理 更新処理_正常', function () {
    // Arrange
    $recordedProduct = RecordedProduct::first();
    $anotherProduct = Product::factory()->create();
    $data = [
        'product' => (String)$anotherProduct->id
    ];
    $this->assertDatabaseMissing('recorded_products', [
        'code' => $recordedProduct->code,
        'product_id' => $data['product'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/recorded-products/{$recordedProduct->id}/edit")->put("/recorded-products/{$recordedProduct->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/recorded-products');
    // DBに更新されていること
    $this->assertDatabaseMissing('recorded_products', [
        'code' => $recordedProduct->code,
        'product_id' => $recordedProduct->product->id,
    ]);
    $this->assertDatabaseHas('recorded_products', [
        'code' => $recordedProduct->code,
        'product_id' => $data['product'],
    ]);
});

test('製造実績管理 更新処理_異常(バリデーション)', function () {
    // Arrange
    $recordedProduct = RecordedProduct::first();
    $data = [
        'product' => ''
    ];
    $this->assertDatabaseHas('recorded_products', [
        'code' => $recordedProduct->code,
        'product_id' => $recordedProduct->product->id,
    ]);
    $this->assertDatabaseMissing('recorded_products', [
        'code' => $recordedProduct->code,
        'product_id' => $data['product'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/recorded-products/{$recordedProduct->id}/edit")->put("/recorded-products/{$recordedProduct->id}", $data);

    // Assert
    // 編集画面にリダイレクトしていること
    $res->assertRedirect("/recorded-products/{$recordedProduct->id}/edit");
    // DBに更新されていないこと
    $this->assertDatabaseHas('recorded_products', [
        'code' => $recordedProduct->code,
        'product_id' => $recordedProduct->product->id,
    ]);
    $this->assertDatabaseMissing('recorded_products', [
        'code' => $recordedProduct->code,
        'product_id' => $data['product'],
    ]);
});

test('製造実績管理 削除処理_正常', function () {
    // Arrange
    $recordedProduct = RecordedProduct::first();

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/recorded-products/{$recordedProduct->id}/edit")->delete("/recorded-products/{$recordedProduct->id}");

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/recorded-products");
    // DBに更新されていること
    $this->assertDatabaseMissing('recorded_products', [
        'id' => $recordedProduct->id,
    ]);
});

// test('製造実績管理 削除処理_異常(DB整合性)', function () {

// });
