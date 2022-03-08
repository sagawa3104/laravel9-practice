<?php

use App\Models\Masters\Unit;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);


test('部位管理 一覧', function () {
    // Arrange
    $count = 16;
    Unit::factory()->count($count)->create();

    // Act
    $res = $this->get('/units');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('units', function(Illuminate\Pagination\LengthAwarePaginator $viewUnits){
        return $viewUnits->lastPage() === 2;
    });
});

test('部位管理 登録画面', function () {
    // Arrange

    // Act
    $res = $this->get('/units/create');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

test('部位管理 登録処理_正常', function () {
    // Arrange
    $data = [
        'unit_code' => 'test_code',
        'unit_name' => 'test_name',
        'x_length' => '10',
        'y_length' => '12',
    ];
    $this->assertDatabaseMissing('units', [
        'code' => $data['unit_code'],
        'name' => $data['unit_name'],
        'x_length' => (Integer)$data['x_length'],
        'y_length' => (Integer)$data['y_length'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/units/create')->post('/units', $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/units');
    // DBに登録されていること
    $this->assertDatabaseHas('units', [
        'code' => $data['unit_code'],
        'name' => $data['unit_name'],
        'x_length' => (Integer)$data['x_length'],
        'y_length' => (Integer)$data['y_length'],
    ]);
});

test('部位管理 登録処理_異常(バリデーション)', function () {
    // Arrange
    $data = [
        'unit_code' => 'test_code',
        'unit_name' => '',
        'x_length' => '10',
        'y_length' => '12',
    ];
    $this->assertDatabaseMissing('units', [
        'code' => $data['unit_code'],
        'name' => $data['unit_name'],
        'x_length' => (Integer)$data['x_length'],
        'y_length' => (Integer)$data['y_length'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/units/create')->post('/units', $data);

    // Assert
    // 自画面をリダイレクトしていること
    $res->assertRedirect('/units/create');
    // DBに登録されていないこと
    $this->assertDatabaseMissing('units', [
        'code' => $data['unit_code'],
        'name' => $data['unit_name'],
        'x_length' => (Integer)$data['x_length'],
        'y_length' => (Integer)$data['y_length'],
    ]);
});

test('部位管理 更新画面', function () {
    // Arrange
    $unit = Unit::factory()->create();
    // Act
    $res = $this->get("/units/{$unit->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewHas('unit', function(Unit $viewUnit) use($unit){
        return $viewUnit->id === $unit->id;
    });
});

test('部位管理 更新処理_正常', function () {
    // Arrange
    $unit = Unit::factory()->create([
        'name' => 'before_test',
        'x_length' => '10',
        'y_length' => '12',
    ]);
    $data = [
        'unit_name' => 'after_test',
        'x_length' => '12',
        'y_length' => '10',
    ];
    $this->assertDatabaseHas('units', [
        'code' => $unit->code,
        'name' => $unit->name,
        'x_length' => 10,
        'y_length' => 12,
    ]);
    $this->assertDatabaseMissing('units', [
        'code' => $unit->code,
        'name' => $data['unit_name'],
        'x_length' => (Integer)$data['x_length'],
        'y_length' => (Integer)$data['y_length'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/units/{$unit->id}/edit")->put("/units/{$unit->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/units');
    // DBに更新されていること
    $this->assertDatabaseMissing('units', [
        'code' => $unit->code,
        'name' => $unit->name,
        'x_length' => 10,
        'y_length' => 12,
    ]);
    $this->assertDatabaseHas('units', [
        'code' => $unit->code,
        'name' => $data['unit_name'],
        'x_length' => (Integer)$data['x_length'],
        'y_length' => (Integer)$data['y_length'],
    ]);
});

test('部位管理 更新処理_異常(バリデーション)', function () {
    // Arrange
    $unit = Unit::factory()->create([
        'name' => 'before_test',
        'x_length' => '10',
        'y_length' => '12',
    ]);
    $data = [
        'unit_name' => '',
        'x_length' => '12',
        'y_length' => '10',
    ];
    $this->assertDatabaseHas('units', [
        'code' => $unit->code,
        'name' => $unit->name,
        'x_length' => 10,
        'y_length' => 12,

    ]);
    $this->assertDatabaseMissing('units', [
        'code' => $unit->code,
        'name' => $data['unit_name'],
        'x_length' => (Integer)$data['x_length'],
        'y_length' => (Integer)$data['y_length'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/units/{$unit->id}/edit")->put("/units/{$unit->id}", $data);

    // Assert
    // 編集画面にリダイレクトしていること
    $res->assertRedirect("/units/{$unit->id}/edit");
    // DBに更新されていないこと
    $this->assertDatabaseHas('units', [
        'code' => $unit->code,
        'name' => $unit->name,
        'x_length' => 10,
        'y_length' => 12,
    ]);
    $this->assertDatabaseMissing('units', [
        'code' => $unit->code,
        'name' => $data['unit_name'],
        'x_length' => (Integer)$data['x_length'],
        'y_length' => (Integer)$data['y_length'],
    ]);
});

test('部位管理 削除処理_正常', function () {
    // Arrange
    $unit = Unit::factory()->create();
    $this->assertDatabaseHas('units', [
        'id' => $unit->id,
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/units/{$unit->id}/edit")->delete("/units/{$unit->id}");

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/units");
    // DBに更新されていること
    $this->assertDatabaseMissing('units', [
        'id' => $unit->id,
    ]);
});

// test('部位管理 削除処理_異常(DB整合性)', function () {

// });
