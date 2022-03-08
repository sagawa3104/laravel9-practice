<?php

use App\Http\Requests\StorePhaseRequest;
use App\Models\Masters\Phase;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);


test('工程コードの必須違反', function () {

    // Arrange
    $data = [
        'phase_code' => '',
    ];
    $request = new StorePhaseRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('phase_code');
    expect($validator->failed()['phase_code'])->toHaveKey('Required');
});

test('工程コードの最大文字列長違反', function () {

    // Arrange
    $data = [
        'phase_code' => str_repeat('a', 33),
    ];
    $request = new StorePhaseRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('phase_code');
    expect($validator->failed()['phase_code'])->toHaveKey('Max');

});

test('工程コードのDBユニーク違反', function () {

    // Arrange
    $data = [
        'phase_code' => Phase::factory()->create()->code,
    ];
    $request = new StorePhaseRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('phase_code');
    expect($validator->failed()['phase_code'])->toHaveKey('Unique');

});

test('工程名称の必須違反', function () {

    // Arrange
    $data = [
        'phase_name' => '',
    ];
    $request = new StorePhaseRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('phase_name');
    expect($validator->failed()['phase_name'])->toHaveKey('Required');

});

test('工程名称の最大文字列長違反', function () {

    // Arrange
    $data = [
        'phase_name' => str_repeat('a', 256),
    ];
    $request = new StorePhaseRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('phase_name');
    expect($validator->failed()['phase_name'])->toHaveKey('Max');

});

test('工程コード・名称の正常データ', function () {

    // Arrange
    $data = [
        'phase_code' => str_repeat('a', 32),
        'phase_name' => str_repeat('a', 255),
    ];
    $request = new StorePhaseRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});

test('正常データ時の補間パラメータのテスト', function () {

    // Arrange
    $data = [
        'phase_code' => str_repeat('a', 32),
        'phase_name' => str_repeat('a', 255),
        'code' => 'uninteded_parameter',
        'name' => 'uninteded_parameter',
    ];
    app()->instance('request', Request::create('', 'GET', $data));

    // Act
    $formRequest = app(StorePhaseRequest::class);
    $input = $formRequest->all();

    // Assert
    expect($input)->toHaveKeys(['code', 'name'])
    ->code->not->toBe($data['code'])->toBe($data['phase_code'])
    ->name->not->toBe($data['name'])->toBe($data['phase_name']);
});
