<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\RememberMeDatabaseUserProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phoneNumber',
        'password',
        'isAdmin',
    ];
    public function carts() {
        return $this->hasMany(Cart::class);
    }
}

