<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KostandFacilities extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function kost(){
        return $this->hasMany(Kost::class, 'id', 'kost_id');
    }

    public function facilities(){
        return $this->hasMany(facilities::class);
    }
}
