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
                'type' => 'ITEM',
                'item_id' => $input['itemId'],
            ]);
        }

        return $recordedInspectionDetail->fresh([
            'recordedInspectionDetailMapping',
            'recordedInspectionDetailMapping.item',
            'recordedInspectionDetailChecking',
            'recordedInspectionDetailChecking.item',
        ]);
    }

    public function destroy(RecordedInspection $recordedInspection, RecordedInspectionDetail $recordedInspectionDetail)
    {
        $recordedInspectionDetail->delete();

        return;
    }

}
