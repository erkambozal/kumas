<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use Sluggable;
    
   protected $fillable = [

    'name',
    'slug',
    'categories',
    'images',
    'content',
    'price',
    'qty',
    'status',

   ];

   public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
//    public function Categories(){
//     return $this->hasMany(Category::class,'id','category_id');
// }

   public function sluggable(): array
        {
            return [
                'slug' => [
                    'source' => 'name'
                ]
            ];
        }
        public function carts() {
            return $this->belongsToMany(Cart::class);
        }
}

