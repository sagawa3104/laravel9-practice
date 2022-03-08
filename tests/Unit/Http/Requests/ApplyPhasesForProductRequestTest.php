<?php

use App\Http\Requests\ApplyPhasesForProductRequest;
use App\Models\Masters\Phase;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('選択部位の存在違反', function () {

    // Arrange
    Phase::factory()->create();
    $data = [
        'phases' => ['9999'],
    ];
    $request = new ApplyPhasesForProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('phases.0');
    expect($validator->failed()['phases.0'])->toHaveKey('Exists');

});

test('全選択全解除択一違反', function () {

    // Arrange
    $data = [
        'all' => ['select'=>'1', 'release' =>'1'],
    ];
    $request = new ApplyPhasesForProductRequest();
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
    $ids = Phase::factory()->count(5)->create()->pluck('id');
    $data = [
        'phases' => $ids->toArray()
    ];
    $request = new ApplyPhasesForProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});

