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
}