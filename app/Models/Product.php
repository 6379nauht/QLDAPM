<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'content',
        'menu_id',
        'price',
        'price_sale',
        'active',
        'thumb'
    ];
 // Mối quan hệ với Category (hoặc Menu nếu bạn sử dụng menu_id)
 public function category()
 {
     return $this->belongsTo(Category::class, 'menu_id');  // 'menu_id' nếu bạn dùng menu_id
 }

 // Nếu cần quan hệ ngược lại với Product
 public function productsRelated()
 {
     return $this->hasMany(Product::class, 'menu_id', 'id');
 }

 // Trong Product.php


public function menu()
{
    return $this->hasOne(Category::class, 'id', 'menu_id')
        ->withDefault(['name' => '']);
}

}
