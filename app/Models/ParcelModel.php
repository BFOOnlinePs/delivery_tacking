<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelModel extends Model
{
    use HasFactory;

    protected $table = 'parcel';

    public function parcel_process(){
        return $this->hasMany(ParcelProcessModel::class , 'parcel_id' , 'id');
    }

    public function lastStatusProcess()
    {
        return $this->hasOne(ParcelProcessModel::class, 'parcel_id', 'id')
                    ->latest();
    }
}
