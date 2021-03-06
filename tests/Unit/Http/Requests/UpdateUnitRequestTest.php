<?php

use App\Http\Requests\UpdateUnitRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('部位名称の必須違反', function () {

    // Arrange
    $data = [
        'unit_name' => '',
    ];
    $request = new UpdateUnitRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('unit_name');
    expect($validator->failed()['unit_name'])->toHaveKey('Required');

});

test('部位名称の最大文字列長違反', function () {

    // Arrange
    $data = [
        'unit_name' => str_repeat('a', 256),
    ];
    $request = new UpdateUnitRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('unit_name');
    expect($validator->failed()['unit_name'])->toHaveKey('Max');

});

test('X軸長の必須違反', function () {

    // Arrange
    $data = [
        'x_length' => '',
    ];
    $request = new UpdateUnitRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('x_length');
    expect($validator->failed()['x_length'])->toHaveKey('Required');
});

test('X軸長の整数違反', function ($x_length) {

    // Arrange
    $data = [
        'x_length' => $x_length,
    ];
    $request = new UpdateUnitRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('x_length');
    expect($validator->failed()['x_length'])->toHaveKey('Integer');

})->with([
    'あ',
    '01',
    '1.1',
]);

test('X軸長の最大最小違反', function ($x_length) {

    // Arrange
    $data = [
        'x_length' => $x_length,
    ];
    $request = new UpdateUnitRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('x_length');
    expect($validator->failed()['x_length'])->toHaveKey('Between');

})->with([
    '0',
    '21'
]);

test('Y軸長の必須違反', function () {

    // Arrange
    $data = [
        'y_length' => '',
    ];
    $request = new UpdateUnitRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('y_length');
    expect($validator->failed()['y_length'])->toHaveKey('Required');
});

test('Y軸長の整数違反', function ($y_length) {

    // Arrange
    $data = [
        'y_length' => $y_length,
    ];
    $request = new UpdateUnitRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('y_length');
    expect($validator->failed()['y_length'])->toHaveKey('Integer');

})->with([
    'あ',
    '01',
    '1.1',
]);

test('Y軸長の最大最小違反', function ($y_length) {

    // Arrange
    $data = [
        'y_length' => $y_length,
    ];
    $request = new UpdateUnitRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('y_length');
    expect($validator->failed()['y_length'])->toHaveKey('Between');

})->with([
    '0',
    '21'
]);

test('部位コード・名称の正常データ', function ($x_length, $y_length) {

    // Arrange
    $data = [
        'unit_name' => str_repeat('a', 255),
        'x_length' => $x_length,
        'y_length' => $y_length,
    ];
    $request = new UpdateUnitRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

})->with([
    ['1', '1'],
    ['20', '20']
]);

test('正常データ時の補間パラメータのテスト', function () {

    // Arrange
    $data = [
        'unit_name' => str_repeat('a', 255),
        'x_length' => 1,
        'y_length' => 1,
        'code' => 'uninteded_parameter',
        'name' => 'uninteded_parameter',
    ];
    app()->instance('request', Request::create('', 'GET', $data));

    // Act
    $formRequest = app(UpdateUnitRequest::class);
    $input = $formRequest->all();

    // Assert
    expect($input)->toHaveKeys(['name'])
    ->code->not->toBe($data['code'])
    ->name->not->toBe($data['name'])->toBe($data['unit_name']);
});
