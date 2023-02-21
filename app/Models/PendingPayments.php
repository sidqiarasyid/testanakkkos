<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingPayments extends Model
{
    use HasFactory;


    protected $guarded =[
        'id'
    ];

    public function detail(){
        return $this->belongsTo(DetailKost::class, 'detail_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
