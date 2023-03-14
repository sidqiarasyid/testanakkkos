<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKost extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    function kost(){
        return $this->belongsTo(Kost::class);
    }

    function user(){
        return $this->belongsTo(User::class, 'seller_id');
    }

    function pending(){
        return $this->hasMany(PendingPayments::class);
    }
}
