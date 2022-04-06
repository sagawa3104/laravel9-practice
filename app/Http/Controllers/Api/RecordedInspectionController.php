<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transactions\RecordedInspection;
use Illuminate\Http\Request;

class RecordedInspectionController extends Controller
{
    public function index(Request $request)
    {
        $recordedInspections = RecordedInspection::search($request->all())->paginate();
        return $recordedInspections;
    }

    public function show(RecordedInspection $recorded_inspection)
    {
        $recorded_inspection->load([
            'phase',
            'recordedProduct',
            'recordedProduct.product',
        ]);
        return $recorded_inspection;
    }

    public function categories(RecordedInspection $recorded_inspection)
    {
        $categories = $recorded_inspection->phase->categories->load(['items', 'specifications']);

        return $categories;
    }

    public function units(RecordedInspection $recorded_inspection)
    {
        $units = $recorded_inspection->recordedProduct->product->units;

        return $units;
    }

    public function details(RecordedInspection $recordedInspection){

        return $recordedInspection->recordedInspectionDetails->load([
            'recordedInspectionDetailMapping',
            'recordedInspectionDetailMapping.item',
            'recordedInspectionDetailChecking',
            'recordedInspectionDetailChecking.item',
        ]);
    }
}
