<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    
    // Guarded fillablenya semua yg ada di table, kecuali yg didalam array.
    // $guarded kebalikan $fillable
    protected $guarded = [];
    // protected $with = ['category'];

    // Penerapan Slug #2 - via Model secara Otomatis akan terbuat
    public static function booted(){
        static::creating(function (Product $product){
            $product->slug = strtolower(Str::slug($product->name . '-' . time()));
        });
    }

    public function getRouteKeyName() //meng-enable akses Single Produk dengan URL Slug
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
