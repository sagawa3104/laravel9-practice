<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Masters\Phase;
use App\Models\Transactions\RecordedInspection;
use Illuminate\Http\Request;

class RecordedInspectionController extends Controller
{
    public function index(Request $request)
    {
        $recordedInspections = RecordedInspection::search($request->all())->paginate();
        return $recordedInspections;
    }

    public function show(RecordedInspection $inspection)
    {
        $inspection->load([
            'process',
            'recordedProduct',
            'recordedProduct.product',
            'inspectionDetails',
            'inspectionDetails.recordedMappingItem',
            'inspectionDetails.recordedMappingItem.mappingItem',
            'inspectionDetails.recordedMappingItem.mappingItem.processPart',
            'inspectionDetails.recordedMappingItem.mappingItem.processPart.part',
        ]);
        return $inspection;
    }
}
