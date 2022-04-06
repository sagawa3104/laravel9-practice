<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transactions\RecordedInspection;
use App\Models\Transactions\RecordedInspectionDetail;
use Illuminate\Http\Request;

class RecordedInspectionDetailController extends Controller
{
    public function store(Request $request, RecordedInspection $recordedInspection){
        $input = $request->all();

        $recordedInspectionDetail = $recordedInspection->recordedInspectionDetails()
        ->create([
            'type' => $input['type'],
            'inspected_result' => 'NG']);

        if($input['type'] === 'MAPPING'){
            $recordedInspectionDetail->recordedInspectionDetailMapping()->create([
                'unit_id' => $input['unitId'],
                'item_id' => $input['itemId'],
                'x_point' => $input['xPoint'],
                'y_point' => $input['yPoint'],
            ]);
        }else{
            $recordedInspectionDetail->recordedInspectionDetailChecking()->create([
                'type' => $input['itemType'],
                'item_id' => isset($input['itemId'])? $input['itemId']:null,
                'specification_id' => isset($input['specificationId'])? $input['specificationId']:null,
                'special_specification_id' => isset($input['specialSpecificationId'])? $input['specialSpecificationId']:null,
            ]);
        }

        return $recordedInspectionDetail->fresh([
            'recordedInspectionDetailMapping',
            'recordedInspectionDetailMapping.item',
            'recordedInspectionDetailChecking',
            'recordedInspectionDetailChecking.item',
            'recordedInspectionDetailChecking.specification',
            'recordedInspectionDetailChecking.specialSpecification',
        ]);
    }

    public function destroy(RecordedInspection $recordedInspection, RecordedInspectionDetail $recordedInspectionDetail)
    {
        $recordedInspectionDetail->delete();

        return;
    }

}
