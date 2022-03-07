<?php

use App\Http\Requests\UpdatePhaseRequest;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('工程名称の必須違反', function () {

    // Arrange
    $data = [
        'phase_name' => '',
    ];
    $request = new UpdatePhaseRequest();
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
    $request = new UpdatePhaseRequest();
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
        'phase_name' => str_repeat('a', 255),
    ];
    $request = new UpdatePhaseRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});
