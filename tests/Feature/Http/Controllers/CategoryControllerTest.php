<?php

use App\Models\Masters\Category;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);


test('カテゴリ管理 一覧', function () {
    // Arrange
    $count = 16;
    Category::factory()->count($count)->create();

    // Act
    $res = $this->get('/categories');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('categories', function(Illuminate\Pagination\LengthAwarePaginator $viewCategorys){
        return $viewCategorys->lastPage() === 2;
    });
});

test('カテゴリ管理 登録画面', function () {
    // Arrange

    // Act
    $res = $this->get('/categories/create');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

test('カテゴリ管理 登録処理_正常', function () {
    // Arrange
    $data = [
        'category_code' => 'test_code',
        'category_name' => 'test_name',
        'form' => 'CHECKLIST'
    ];
    $this->assertDatabaseMissing('categories', [
        'code' => $data['category_code'],
        'name' => $data['category_name'],
        'form' => $data['form'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/categories/create')->post('/categories', $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/categories');
    // DBに登録されていること
    $this->assertDatabaseHas('categories', [
        'code' => $data['category_code'],
        'name' => $data['category_name'],
        'form' => $data['form'],
    ]);
});

test('カテゴリ管理 登録処理_異常(バリデーション)', function () {
    // Arrange
    $data = [
        'category_code' => 'test_code',
        'category_name' => '',
        'form' => 'CHECKLIST'
    ];
    $this->assertDatabaseMissing('categories', [
        'code' => $data['category_code'],
        'name' => $data['category_name'],
        'form' => $data['form'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/categories/create')->post('/categories', $data);

    // Assert
    // 自画面をリダイレクトしていること
    $res->assertRedirect('/categories/create');
    // DBに登録されていないこと
    $this->assertDatabaseMissing('categories', [
        'code' => $data['category_code'],
        'name' => $data['category_name'],
        'form' => $data['form'],
    ]);
});

test('カテゴリ管理 更新画面', function () {
    // Arrange
    $category = Category::factory()->create();
    // Act
    $res = $this->get("/categories/{$category->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewHas('category', function(Category $viewCategory) use($category){
        return $viewCategory->id === $category->id;
    });
});

test('カテゴリ管理 更新処理_正常', function () {
    // Arrange
    $category = Category::factory()->create([
        'name' => 'before_test',
        'form' => 'CHECKLIST'
    ]);
    $data = [
        'category_name' => 'after_test',
        'form' => 'MAPPING'
    ];
    $this->assertDatabaseHas('categories', [
        'code' => $category->code,
        'name' => $category->name,
        'form' => $category->form,
    ]);
    $this->assertDatabaseMissing('categories', [
        'code' => $category->code,
        'name' => $data['category_name'],
        'form' => $data['form'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/categories/{$category->id}/edit")->put("/categories/{$category->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/categories');
    // DBに更新されていること
    $this->assertDatabaseMissing('categories', [
        'code' => $category->code,
        'name' => $category->name,
        'form' => $category->form,
    ]);
    $this->assertDatabaseHas('categories', [
        'code' => $category->code,
        'name' => $data['category_name'],
        'form' => $data['form'],
    ]);
});

test('カテゴリ管理 更新処理_異常(バリデーション)', function () {
    // Arrange
    $category = Category::factory()->create([
        'name' => 'before_test',
        'form' => 'CHECKLIST'
    ]);
    $data = [
        'category_name' => '',
        'form' => 'MAPPING'
    ];
    $this->assertDatabaseHas('categories', [
        'code' => $category->code,
        'name' => $category->name,
        'form' => $category->form,
    ]);
    $this->assertDatabaseMissing('categories', [
        'code' => $category->code,
        'name' => $data['category_name'],
        'form' => $data['form'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/categories/{$category->id}/edit")->put("/categories/{$category->id}", $data);

    // Assert
    // 編集画面にリダイレクトしていること
    $res->assertRedirect("/categories/{$category->id}/edit");
    // DBに更新されていないこと
    $this->assertDatabaseHas('categories', [
        'code' => $category->code,
        'name' => $category->name,
        'form' => $category->form,
    ]);
    $this->assertDatabaseMissing('categories', [
        'code' => $category->code,
        'name' => $data['category_name'],
        'form' => $data['form'],
    ]);
});

test('カテゴリ管理 削除処理_正常', function () {
    // Arrange
    $category = Category::factory()->create();
    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/categories/{$category->id}/edit")->delete("/categories/{$category->id}");

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/categories");
    // DBに更新されていること
    $this->assertDatabaseMissing('categories', [
        'id' => $category->id,
    ]);
});

// test('カテゴリ管理 削除処理_異常(DB整合性)', function () {

// });
