<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'role',
        'pfp',
        'chat_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    
     protected $hidden = [
        'password'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function chatroom(){
        return $this->hasOne(KostChat::class);
    }

    public function comment()
    {
        return $this->hasMany(Comments::class, 'user_id');
    }

    public function transaction(){
        return $this->hasMany(Transactions::class);
    }

    public function kost(){
        return $this->hasMany(Kost::class);
    }

    public function message(){
        return $this->hasMany(Message::class);
    }
}
