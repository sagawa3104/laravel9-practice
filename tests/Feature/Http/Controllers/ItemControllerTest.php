<?php

use App\Models\Masters\Item;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);


test('項目管理 一覧', function () {
    // Arrange
    $count = 16;
    Item::factory()->count($count)->create();

    // Act
    $res = $this->get('/items');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('items', function(Illuminate\Pagination\LengthAwarePaginator $viewItems){
        return $viewItems->lastPage() === 2;
    });
});

test('項目管理 登録画面', function () {
    // Arrange

    // Act
    $res = $this->get('/items/create');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

test('項目管理 登録処理_正常', function () {
    // Arrange
    $data = [
        'item_code' => 'test_code',
        'item_name' => 'test_name'
    ];
    $this->assertDatabaseMissing('items', [
        'code' => $data['item_code'],
        'name' => $data['item_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/items/create')->post('/items', $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/items');
    // DBに登録されていること
    $this->assertDatabaseHas('items', [
        'code' => $data['item_code'],
        'name' => $data['item_name'],
    ]);
});

test('項目管理 登録処理_異常(バリデーション)', function () {
    // Arrange
    $data = [
        'item_code' => 'test_code',
        'item_name' => ''
    ];
    $this->assertDatabaseMissing('items', [
        'code' => $data['item_code'],
        'name' => $data['item_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/items/create')->post('/items', $data);

    // Assert
    // 自画面をリダイレクトしていること
    $res->assertRedirect('/items/create');
    // DBに登録されていないこと
    $this->assertDatabaseMissing('items', [
        'code' => $data['item_code'],
        'name' => $data['item_name'],
    ]);
});

test('項目管理 更新画面', function () {
    // Arrange
    $item = Item::factory()->create();
    // Act
    $res = $this->get("/items/{$item->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewHas('item', function(Item $viewItem) use($item){
        return $viewItem->id === $item->id;
    });
});

test('項目管理 更新処理_正常', function () {
    // Arrange
    $item = Item::factory()->create([
        'name' => 'before_test'
    ]);
    $data = [
        'item_name' => 'after_test'
    ];
    $this->assertDatabaseHas('items', [
        'code' => $item->code,
        'name' => $item->name,
    ]);
    $this->assertDatabaseMissing('items', [
        'code' => $item->code,
        'name' => $data['item_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/items/{$item->id}/edit")->put("/items/{$item->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/items');
    // DBに更新されていること
    $this->assertDatabaseMissing('items', [
        'code' => $item->code,
        'name' => $item->name,
    ]);
    $this->assertDatabaseHas('items', [
        'code' => $item->code,
        'name' => $data['item_name'],
    ]);
});

test('項目管理 更新処理_異常(バリデーション)', function () {
    // Arrange
    $item = Item::factory()->create([
        'name' => 'before_test'
    ]);
    $data = [
        'item_name' => ''
    ];
    $this->assertDatabaseHas('items', [
        'code' => $item->code,
        'name' => $item->name,
    ]);
    $this->assertDatabaseMissing('items', [
        'code' => $item->code,
        'name' => $data['item_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/items/{$item->id}/edit")->put("/items/{$item->id}", $data);

    // Assert
    // 編集画面にリダイレクトしていること
    $res->assertRedirect("/items/{$item->id}/edit");
    // DBに更新されていないこと
    $this->assertDatabaseHas('items', [
        'code' => $item->code,
        'name' => $item->name,
    ]);
    $this->assertDatabaseMissing('items', [
        'code' => $item->code,
        'name' => $data['item_name'],
    ]);
});

test('項目管理 削除処理_正常', function () {
    // Arrange
    $item = Item::factory()->create();
    $this->assertDatabaseHas('items', [
        'id' => $item->id,
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/items/{$item->id}/edit")->delete("/items/{$item->id}");

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/items");
    // DBに更新されていること
    $this->assertDatabaseMissing('items', [
        'id' => $item->id,
    ]);
});

// test('項目管理 削除処理_異常(DB整合性)', function () {

// });
