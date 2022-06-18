<?php

namespace App\Models;

use App\Models\ProductLike;
use App\Models\ProductOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = array(
        'name',
        'email',
        'password',
        'image',
        'role',
    );

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = array(
        'password',
        'remember_token',
    );

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = array(
        'email_verified_at' => 'datetime',
    );

    public function order() {
        return $this->hasMany( ProductOrder::class );
    }

    public function cart() {
        return $this->hasMany( ProductCart::class );
    }

    public function favourite() {
        return $this->hasMany( ProductLike::class );
    }
}
