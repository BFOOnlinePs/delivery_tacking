<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelExceptionsModel extends Model
{
    use HasFactory;

    protected $table = 'parcel_exceptions';

    protected $fillable = [
        'barcode','user_id','insert_at','status'
    ];
}
