<?php

namespace App\Http\Controllers;

use App\Exports\ParcelProcessExport;
use App\Models\ParcelModel;
use App\Models\ParcelProcessModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(){
        $users = User::where('user_role','client')->get();
        return view('projects.report.index',['users'=>$users]);
    }


    public function report_list(Request $request)
    {
        $data = ParcelModel::with('parcel_process');
        
        if(auth()->user()->user_role == 'client'){
            $data = $data->where('user_id', auth()->user()->id);
            if ($request->filled('no_parcel_process') && $request->no_parcel_process == 'true') {
                $parcelIds = DB::table('parcel_process')->pluck('parcel_id')->toArray();
                $data = $data->whereNotIn('id', $parcelIds);
            }
        }
        if(auth()->user()->user_role == 'admin'){
            if($request->filled('user_id')){
                $data = $data->where('user_id',$request->user_id);
            }
            if ($request->filled('no_parcel_process') && $request->no_parcel_process == 'true') {
                $parcelIds = DB::table('parcel_process')->pluck('parcel_id')->toArray();
                $data = $data->whereNotIn('id', $parcelIds);
            }
        }

    $data = $data->orderBy('id','desc')->get();

    return response()->json([
        'success' => true,
        'view' => view('projects.report.ajax.report_list', ['data' => $data])->render(),
    ]);
    }

    public function report_excel(Request $request)
    {
        return Excel::download(new ParcelProcessExport($request), 'report.xlsx');
    }
}
