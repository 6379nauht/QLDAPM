<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'content',
        'active',
        'thumb'
    ];

     // Mối quan hệ với danh mục con
     public function children()
     {
         return $this->hasMany(Category::class, 'parent_id');
     }
 
     // Mối quan hệ với danh mục cha (nếu có)
     public function parent()
     {
         return $this->belongsTo(Category::class, 'parent_id');
     }

        // Mối quan hệ với sản phẩm
    public function products()
    {
        return $this->hasMany(Product::class, 'menu_id');
    }


    
}
