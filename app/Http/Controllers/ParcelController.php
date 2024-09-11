<?php

namespace App\Http\Controllers;

use App\Models\ParcelModel;
use App\Models\ParcelProcessModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ParcelController extends Controller
{
    public function index(){
        $data = ParcelModel::get();
        return view('projects.parcel.index',['data'=>$data]);
    }

    public function add(){
        return view('projects.parcel.add');
    }

    public function create(Request $request){
       $data = new ParcelModel();
       $data->barcode = $request->barcode;
       $data->status = 'enter';
       $data->notes = $request->notes;
       $data->insert_at = Carbon::now();
       if($data->save()){
            return redirect()->route('parcel.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
       }
    }

    public function create_collection_ajax(Request $request){
        $data = new ParcelProcessModel();
        $data->parcel_id = $request->parcel_id;
        $data->status_process = 'collection';
        $data->insert_at = Carbon::now();
        $data->user_id = auth()->user()->id;
        if($data->save()){
            return response()->json([
                'success'=>true,
                'message'=>'تم تعديل البيانات بنجاح'
            ]);
        }
    }
}