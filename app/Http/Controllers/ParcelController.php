<?php

namespace App\Http\Controllers;

use App\Imports\CollectionExcel;
use App\Models\ParcelExceptionsModel;
use App\Models\ParcelModel;
use App\Models\ParcelProcessModel;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ParcelController extends Controller
{
    public function index(){
        $data = ParcelModel::where('user_id',auth()->user()->id)->get();
        return view('projects.parcel.index',['data'=>$data]);
    }

    public function add(){
        $data = ParcelModel::orderBy('id','desc')->where('user_id',auth()->user()->id)->get();
        return view('projects.parcel.add',['data'=>$data]);
    }

    public function create(Request $request){
        $check_if_found = ParcelModel::where('barcode',$request->barcode)->where('user_id',auth()->user()->id)->first();
        if(empty($check_if_found)){
            $data = new ParcelModel();
            $data->barcode = $request->barcode;
            $data->status = 'enter';
            $data->notes = $request->notes;
            $data->insert_at = Carbon::now();
            $data->user_id = auth()->user()->id;
            if($data->save()){
                 return redirect()->route('parcel.add')->with(['success'=>'تم اضافة البيانات بنجاح' , 'barcode'=>$request->barcode , 'timer'=>3000]);
            }
        }
        else{
            return redirect()->route('parcel.add')->with(['fail'=>'هذا الباركود موجود مسبقا' , 'barcode'=>$request->barcode , 'timer'=>3000]);
        }
    }

    public function delete($id){
        $data = ParcelModel::find($id);
        if($data->delete()){
            return redirect()->route('parcel.add')->with(['success'=>'تم حذف البيانات بنجاح' , 'timer'=>3000]);
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

    public function collection_excel(Request $request)
{
    $importedData = Excel::toArray(new CollectionExcel, $request->file('collection_excel'));
    $data = $importedData[0];

    $existingBarcodes = []; // Array to store existing barcodes
    $newRecords = []; // Array to store new records
    $exceptionRecords = []; // Array to store exception records
    $existingProcessRecords = []; // Array to store existing parcel process records

    foreach ($data as $row) { // Use $data instead of $importedData
        $barcode = $row[0]; // Ensure this is the barcode (string)

        $existingParcel = ParcelModel::where('barcode', $barcode)->first(); // Check if the barcode exists in the table

        if ($existingParcel) { 
            $existingParcelProcess = ParcelProcessModel::where('parcel_id', $existingParcel->id)->first(); 
            
            if ($existingParcelProcess) {
                // If the process already exists, add the barcode and process ID to the existing records
                $existingBarcodes[] = [
                    'barcode' => $barcode,
                    'process_id' => $existingParcelProcess->id // Store the existing process ID
                ];
            } else {
                ParcelProcessModel::create([
                    'parcel_id' => $existingParcel->id,
                    'status_process' => 'collection',
                    'insert_at' => Carbon::now(),
                    'user_id' => auth()->user()->id
                ]);
    
                $newRecords[] = $barcode;
            }
        } else {
            // Include the parcel_id and barcode in the exception model
            ParcelExceptionsModel::firstOrCreate(
                [
                    'barcode' => (string)$barcode, // Ensure barcode is a string
                ],
                [
                    'user_id' => auth()->user()->id,
                    'status' => 'exception',
                    'insert_at' => Carbon::now(),
                    'parcel_id' => $existingParcel->id ?? null, // Include parcel_id if available
                ]
            );

            // Save both barcode and parcel_id for exception records
            $exceptionRecords[] = [
                'barcode' => $barcode,
                'parcel_id' => $existingParcel->id ?? null // Save parcel_id if available
            ]; 
        }
    }

    return response()->json([
        'existing_barcodes' => $existingBarcodes, // Now includes process IDs
        'new_records' => $newRecords, 
        'exception_records' => $exceptionRecords 
    ]);    
}

public function returned_excel(Request $request)
{
    $importedData = Excel::toArray(new CollectionExcel, $request->file('returned_excel'));
    $data = $importedData[0];

    $existingBarcodes = []; // Array to store existing barcodes
    $newRecords = []; // Array to store new records
    $exceptionRecords = []; // Array to store exception records
    $existingProcessRecords = []; // Array to store existing parcel process records

    foreach ($data as $row) { // Use $data instead of $importedData
        $barcode = $row[0]; // Ensure this is the barcode (string)

        $existingParcel = ParcelModel::where('barcode', $barcode)->first(); // Check if the barcode exists in the table

        if ($existingParcel) { 
            $existingParcelProcess = ParcelProcessModel::where('parcel_id', $existingParcel->id)->first(); 
            
            if ($existingParcelProcess) {
                // If the process already exists, add the barcode and process ID to the existing records
                $existingBarcodes[] = [
                    'barcode' => $barcode,
                    'process_id' => $existingParcelProcess->id // Store the existing process ID
                ];
            } else {
                ParcelProcessModel::create([
                    'parcel_id' => $existingParcel->id,
                    'status_process' => 'returned',
                    'insert_at' => Carbon::now(),
                    'user_id' => auth()->user()->id
                ]);
    
                $newRecords[] = $barcode;
            }
        } else {
            // Include the parcel_id and barcode in the exception model
            ParcelExceptionsModel::firstOrCreate(
                [
                    'barcode' => (string)$barcode, // Ensure barcode is a string
                ],
                [
                    'user_id' => auth()->user()->id,
                    'status' => 'exception',
                    'insert_at' => Carbon::now(),
                    'parcel_id' => $existingParcel->id ?? null, // Include parcel_id if available
                ]
            );

            // Save both barcode and parcel_id for exception records
            $exceptionRecords[] = [
                'barcode' => $barcode,
                'parcel_id' => $existingParcel->id ?? null // Save parcel_id if available
            ]; 
        }
    }

    return response()->json([
        'existing_barcodes' => $existingBarcodes, // Now includes process IDs
        'new_records' => $newRecords, 
        'exception_records' => $exceptionRecords 
    ]);    
}

public function switch_excel(Request $request)
{
    $importedData = Excel::toArray(new CollectionExcel, $request->file('switch_excel'));
    $data = $importedData[0];

    $existingBarcodes = []; // Array to store existing barcodes
    $newRecords = []; // Array to store new records
    $exceptionRecords = []; // Array to store exception records
    $existingProcessRecords = []; // Array to store existing parcel process records

    foreach ($data as $row) { // Use $data instead of $importedData
        $barcode = $row[0]; // Ensure this is the barcode (string)

        $existingParcel = ParcelModel::where('barcode', $barcode)->first(); // Check if the barcode exists in the table

        if ($existingParcel) { 
            $existingParcelProcess = ParcelProcessModel::where('parcel_id', $existingParcel->id)->first(); 
            
            if ($existingParcelProcess) {
                // If the process already exists, add the barcode and process ID to the existing records
                $existingBarcodes[] = [
                    'barcode' => $barcode,
                    'process_id' => $existingParcelProcess->id // Store the existing process ID
                ];
            } else {
                ParcelProcessModel::create([
                    'parcel_id' => $existingParcel->id,
                    'status_process' => 'switch',
                    'insert_at' => Carbon::now(),
                    'user_id' => auth()->user()->id
                ]);
    
                $newRecords[] = $barcode;
            }
        } else {
            // Include the parcel_id and barcode in the exception model
            ParcelExceptionsModel::firstOrCreate(
                [
                    'barcode' => (string)$barcode, // Ensure barcode is a string
                ],
                [
                    'user_id' => auth()->user()->id,
                    'status' => 'exception',
                    'insert_at' => Carbon::now(),
                    'parcel_id' => $existingParcel->id ?? null, // Include parcel_id if available
                ]
            );

            // Save both barcode and parcel_id for exception records
            $exceptionRecords[] = [
                'barcode' => $barcode,
                'parcel_id' => $existingParcel->id ?? null // Save parcel_id if available
            ]; 
        }
    }

    return response()->json([
        'existing_barcodes' => $existingBarcodes, // Now includes process IDs
        'new_records' => $newRecords, 
        'exception_records' => $exceptionRecords 
    ]);    
}

public function add_collection_page(){
    $data = ParcelProcessModel::with('parcel')->where('status_process','collection')->where('user_id',auth()->user()->id)->get();
    return view('projects.parcel.add_collection',['data'=>$data]);
}

public function add_return_page(){
    $data = ParcelProcessModel::with('parcel')->where('status_process','returned')->where('user_id',auth()->user()->id)->get();
    return view('projects.parcel.add_return',['data'=>$data]);
}

public function add_switch_page(){
    $data = ParcelProcessModel::with('parcel')->where('status_process','switch')->where('user_id',auth()->user()->id)->get();
    return view('projects.parcel.add_switch',['data'=>$data]);
}


public function create_parcel_process(Request $request){
    $check_if_found = ParcelModel::where('barcode',$request->barcode)->where('user_id',auth()->user()->id)->first();
    if(empty($check_if_found)){
        // return response()->json([
        //     'success'=>true,
        //     'status'=>'not_found',
        //     'message'=>'هذا الكود غير موجود'
        // ]);
        return redirect()->back()->with(['fail'=>'هذا الباركود غير موجود' , 'barcode'=>$request->barcode , 'timer'=>3000]);
    }
    else {
        $check_parcel_process_is_exist = ParcelProcessModel::where('parcel_id', $check_if_found->id)->first();
        
        if (empty($check_parcel_process_is_exist)) {
            // إضافة البيانات إذا لم يكن موجودًا
            $data = new ParcelProcessModel();
            $data->status_process = $request->status_process;
            $data->insert_at = Carbon::now();
            $data->user_id = auth()->user()->id;
            $data->parcel_id = $check_if_found->id;
            if ($data->save()) {
                return redirect()->back()->with([
                    'success' => 'تم اضافة البيانات بنجاح',
                    'barcode' => $request->barcode,
                    'timer' => 3000
                ]);
            }
        } else {
            // إظهار رسالة تأكيد للمستخدم
            return redirect()->back()->with([
                'warning' => 'هذا الباركود موجود مسبقًا، هل تريد إضافته على أي حال؟',
                'barcode' => $request->barcode,
                'status_process' => $request->status_process,
                'timer' => 3000
            ]);
        }
    }
}


public function confirm_add_parcel_process(Request $request) {
    $check_if_found = ParcelModel::where('barcode', $request->barcode)
                                ->where('user_id', auth()->user()->id)
                                ->first();
    
    if ($check_if_found) {
        $data = new ParcelProcessModel();
        $data->status_process = $request->status_process;
        $data->insert_at = Carbon::now();
        $data->parcel_id = $check_if_found->id;
        $data->user_id = auth()->user()->id;
        if ($data->save()) {
            return redirect()->back()->with([
                'success' => 'تم اضافة البيانات بنجاح',
                'barcode' => $request->barcode,
                'timer' => 3000
            ]);
        }
    }

    return redirect()->route('parcel.add_collection_page')->with([
        'fail' => 'حدث خطأ أثناء الإضافة.',
        'timer' => 3000
    ]);
}
}