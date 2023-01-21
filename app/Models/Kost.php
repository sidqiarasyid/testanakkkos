<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function comment()
    {
        return $this->hasMany(Comments::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facilities::class);
    }

    public function transaction(){
        return $this->hasMany(Transactions::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'seller_id');
    }



    

    
}
