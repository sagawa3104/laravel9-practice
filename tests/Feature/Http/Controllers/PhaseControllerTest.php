<?php

use App\Models\Masters\Phase;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);


test('工程管理 一覧', function () {
    // Arrange
    $count = 16;
    Phase::factory()->count($count)->create();

    // Act
    $res = $this->get('/phases');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('phases', function(Illuminate\Pagination\LengthAwarePaginator $viewPhases){
        return $viewPhases->lastPage() === 2;
    });
});

test('工程管理 登録画面', function () {
    // Arrange

    // Act
    $res = $this->get('/phases/create');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

test('工程管理 登録処理_正常', function () {
    // Arrange
    $data = [
        'phase_code' => 'test_code',
        'phase_name' => 'test_name'
    ];
    $this->assertDatabaseMissing('phases', [
        'code' => $data['phase_code'],
        'name' => $data['phase_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/phases/create')->post('/phases', $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/phases');
    // DBに登録されていること
    $this->assertDatabaseHas('phases', [
        'code' => $data['phase_code'],
        'name' => $data['phase_name'],
    ]);
});

test('工程管理 登録処理_異常(バリデーション)', function () {
    // Arrange
    $data = [
        'phase_code' => 'test_code',
        'phase_name' => ''
    ];
    $this->assertDatabaseMissing('phases', [
        'code' => $data['phase_code'],
        'name' => $data['phase_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/phases/create')->post('/phases', $data);

    // Assert
    // 自画面をリダイレクトしていること
    $res->assertRedirect('/phases/create');
    // DBに登録されていないこと
    $this->assertDatabaseMissing('phases', [
        'code' => $data['phase_code'],
        'name' => $data['phase_name'],
    ]);
});

test('工程管理 更新画面', function () {
    // Arrange
    $phase = Phase::factory()->create();
    // Act
    $res = $this->get("/phases/{$phase->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewHas('phase', function(Phase $viewPhase) use($phase){
        return $viewPhase->id === $phase->id;
    });
});

test('工程管理 更新処理_正常', function () {
    // Arrange
    $phase = Phase::factory()->create([
        'name' => 'before_test'
    ]);
    $data = [
        'phase_name' => 'after_test'
    ];
    $this->assertDatabaseHas('phases', [
        'code' => $phase->code,
        'name' => $phase->name,
    ]);
    $this->assertDatabaseMissing('phases', [
        'code' => $phase->code,
        'name' => $data['phase_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/phases/{$phase->id}/edit")->put("/phases/{$phase->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/phases');
    // DBに更新されていること
    $this->assertDatabaseMissing('phases', [
        'code' => $phase->code,
        'name' => $phase->name,
    ]);
    $this->assertDatabaseHas('phases', [
        'code' => $phase->code,
        'name' => $data['phase_name'],
    ]);
});

test('工程管理 更新処理_異常(バリデーション)', function () {
    // Arrange
    $phase = Phase::factory()->create([
        'name' => 'before_test'
    ]);
    $data = [
        'phase_name' => ''
    ];
    $this->assertDatabaseHas('phases', [
        'code' => $phase->code,
        'name' => $phase->name,
    ]);
    $this->assertDatabaseMissing('phases', [
        'code' => $phase->code,
        'name' => $data['phase_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/phases/{$phase->id}/edit")->put("/phases/{$phase->id}", $data);

    // Assert
    // 編集画面にリダイレクトしていること
    $res->assertRedirect("/phases/{$phase->id}/edit");
    // DBに更新されていないこと
    $this->assertDatabaseHas('phases', [
        'code' => $phase->code,
        'name' => $phase->name,
    ]);
    $this->assertDatabaseMissing('phases', [
        'code' => $phase->code,
        'name' => $data['phase_name'],
    ]);
});

test('工程管理 削除処理_正常', function () {
    // Arrange
    $phase = Phase::factory()->create();
    $this->assertDatabaseHas('phases', [
        'id' => $phase->id,
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/phases/{$phase->id}/edit")->delete("/phases/{$phase->id}");

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/phases");
    // DBに更新されていること
    $this->assertDatabaseMissing('phases', [
        'id' => $phase->id,
    ]);
});

// test('工程管理 削除処理_異常(DB整合性)', function () {

// });
