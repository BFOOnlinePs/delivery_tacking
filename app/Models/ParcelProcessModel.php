<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParcelProcessModel extends Model
{
    use HasFactory;

    protected $table = 'parcel_process';

    protected $fillable = [
        'parcel_id','status_process','insert_at','user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

    public function parcel(){
        return $this->belongsTo(ParcelModel::class , 'parcel_id' , 'id');
    }
}
