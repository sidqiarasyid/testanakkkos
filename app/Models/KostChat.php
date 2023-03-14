<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KostChat extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function kost(){
        return $this->belongsTo(Kost::class);
    }

    public function message(){
        return $this->hasMany(Message::class);
    }
}
