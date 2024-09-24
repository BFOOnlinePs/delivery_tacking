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
        $data = ParcelModel::with('parcel_process' , 'parcel_process.user')->where('user_id',$request->user_id)->orderBy('id','desc')->get();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }

    public function create(Request $request){
        $if_exist = ParcelModel::where('barcode',$request->barcode)->first();
        if($if_exist){
            return response()->json([
                'success'=>true,
                'status'=>'exist',
                'message'=>'هذا الباركود موجود مسبقا'
            ]);
        }
        else{
            $data = new ParcelModel();
            $data->barcode = $request->barcode;
            $data->status = 'enter';
            $data->notes = $request->notes;
            $data->insert_at = Carbon::now();
            $data->image = $request->photo_name;
            $data->user_id = $request->user_id;
            if($data->save()){
                return response()->json([
                    'success'=>true,
                    'message'=>'تم اضافة الطرد بنجاح'
                ]);
            }
        }
    }

    public function create_parcel_process(Request $request){
        $parcel = ParcelModel::where('barcode',$request->barcode)->first();
        
        if($parcel){
            $if_found = ParcelProcessModel::where('parcel_id',$parcel->id)->first();
            if($if_found){
                return response()->json([
                    'success'=>true,
                    'status' => 'exist',
                    'data' => ParcelProcessModel::with('user' , 'parcel')->where('parcel_id',$parcel->id)->get(),
                    'parcel' => $parcel
                ]);
            }
            else{
                $parcel_process = new ParcelProcessModel();
                $parcel_process->parcel_id = $parcel->id;
                $parcel_process->status_process = $request->status;
                $parcel_process->insert_at = Carbon::now();
                $parcel_process->user_id = $request->user_id;
                if($parcel_process->save()){
                    return response()->json([
                        'success'=>true,
                        'status'=>'not_exist',
                        'message'=>'تم تحصيل الطرد بنجاح'
                    ]);
                }
            }
        }
        else{
            return response()->json([
                'success'=>true,
                'status'=>'not_found',
                'message'=>'هذا الباركود غير مسجل'
            ]);
        }
    }

    public function create_parcel_process_anyway(Request $request){
        $parcel = ParcelModel::where('barcode',$request->barcode)->first();
        $data = new ParcelProcessModel();
        $data->parcel_id = $parcel->id;
        $data->status_process = $request->status_process;
        $data->insert_at = Carbon::now();
        $data->user_id = $request->user_id;
        if($data->save()){
            return response()->json([
                'success'=>true,
                'message'=>'تم اضافة البيانات بنجاح'
            ]);
        }
    }

    public function list_parcel_process(Request $request){
        $data = ParcelProcessModel::where('user_id',$request->user_id)->get();
        return response()->json([
            'success'=>true,
            'data'=>$data  
        ]);
    }
}
