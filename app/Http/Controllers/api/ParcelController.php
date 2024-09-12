<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ParcelModel;
use App\Models\ParcelProcessModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ParcelController extends Controller
{
    public function parcel_list(Request $request){
        $data = ParcelModel::get();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }

    public function create(Request $request){
        $data = new ParcelModel();
        $data->barcode = $request->barcode;
        $data->status = 'enter';
        $data->notes = $request->notes;
        $data->insert_at = Carbon::now();
        if($data->save()){
            return response()->json([
                'success'=>true,
                'message'=>'تم اضافة الطرد بنجاح'
            ]);
        }
    }

    public function create_parcel_process(Request $request){
        $parcel = ParcelModel::where('barcode',$request->barcode)->first();
        
        if($parcel){
            $parcel_process = new ParcelProcessModel();
            $parcel_process->parcel_id = $parcel->id;
            $parcel_process->status_process = 'collection';
            $parcel_process->insert_at = Carbon::now();
            $parcel_process->user_id = $request->user_id;
            if($parcel_process->save()){
                return response()->json([
                    'success'=>true,
                    'message'=>'تم تحصيل الطرد بنجاح'
                ]);
            }
        }
        else{
            return response()->json([
                'success'=>true,
                'message'=>'هذا الباركود مستخدم مسبقا'
            ]);
        }
    }
}
