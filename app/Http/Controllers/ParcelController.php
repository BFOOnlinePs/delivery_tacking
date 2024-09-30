<?php

namespace App\Http\Controllers;

use App\Imports\CollectionExcel;
use App\Models\ParcelModel;
use App\Models\ParcelProcessModel;
use Barryvdh\Debugbar\Facades\Debugbar as FacadesDebugbar;
use Carbon\Carbon;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ParcelController extends Controller
{
    public function index(){
        $data = ParcelModel::where('user_id',auth()->user()->id)->get();
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
       $data->user_id = auth()->user()->id;
       if($data->save()){
            return redirect()->route('parcel.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
       }
    }

    public function create_parcel_process_ajax(Request $request){
        $data = new ParcelProcessModel();
        $data->parcel_id = $request->parcel_id;
        $data->status_process = $request->status_process;
        $data->insert_at = Carbon::now();
        $data->user_id = auth()->user()->id;
        if($data->save()){
            return response()->json([
                'success'=>true,
                'message'=>'تم تعديل البيانات بنجاح'
            ]);
        }
    }

    public function collection_excel(Request $request){
        $importedData = Excel::toArray(new CollectionExcel, $request->file('collection_excel'));

        $data = $importedData[0];
        FacadesDebugbar::info($data);
        return response()->json(['data' => $data]);    
    }
}