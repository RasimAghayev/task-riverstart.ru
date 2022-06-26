<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id', 'name', 'detail', 'price'
    ];
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::created(callback: function ($product) {
            $product->user_id=Auth::id();
            $product->save();
        });
    }
}
