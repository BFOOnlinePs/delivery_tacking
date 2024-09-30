<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class CollectionExcel implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        
    }
}
