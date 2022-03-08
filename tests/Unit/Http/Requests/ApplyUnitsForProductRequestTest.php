<?php

use App\Http\Requests\ApplyUnitsForProductRequest;
use App\Models\Masters\Unit;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('選択部位の存在違反', function () {

    // Arrange
    Unit::factory()->create();
    $data = [
        'units' => ['9999'],
    ];
    $request = new ApplyUnitsForProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('units.0');
    expect($validator->failed()['units.0'])->toHaveKey('Exists');

});

test('全選択全解除択一違反', function () {

    // Arrange
    $data = [
        'all' => ['select'=>'1', 'release' =>'1'],
    ];
    $request = new ApplyUnitsForProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('all');
    expect($validator->failed()['all'])->toHaveKey('Max');

});

test('正常データ', function () {

    // Arrange
    $ids = Unit::factory()->count(5)->create()->pluck('id');
    $data = [
        'units' => $ids->toArray()
    ];
    $request = new ApplyUnitsForProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});

