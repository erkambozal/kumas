<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
protected $fillable = [
    'user_id',
    'products',
    'delivery_name',
    'delivery_surname',
    'delivery_phone',
    'delivery_email',
    'delivery_address',
    'delivery_note',
    'order_date',
    'total_amount',
    'status',
];
public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    
}
