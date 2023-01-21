<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function kost()
    {
        return $this->belongsTo(Kost::class, 'kost_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }



    
}
