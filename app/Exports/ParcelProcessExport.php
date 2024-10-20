<?php

namespace App\Exports;

use App\Models\ParcelProcessModel;
use Maatwebsite\Excel\Concerns\FromCollection;
class ParcelProcessExport implements FromCollection
{
    protected $request;
    public function __construct($request){
        $this->request = $request;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = ParcelProcessModel::query();
        $data = $data->where('user_id', auth()->user()->id);
        if ($this->request->filled('from_date') && $this->request->filled('to_date')) {
            $data = $data->whereBetween('insert_at', [$this->request->from_date, $this->request->to_date]);
        }
        return $data->get();
    }
}
