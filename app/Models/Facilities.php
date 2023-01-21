<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function Kost()
    {
        return $this->belongsTo(Kost::class);
    }
    
}
