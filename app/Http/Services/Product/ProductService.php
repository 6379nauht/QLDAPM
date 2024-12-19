<?php


namespace App\Http\Services\Product;


use App\Models\Product;

class ProductService
{
    const LIMIT = 8;

    public function get($page = null)
    {
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->orderByDesc('id')
            ->when($page != null, function ($query) use ($page) {
                $query->offset($page * self::LIMIT);
            })
            ->limit(self::LIMIT)
            ->get();
    }

    public function show($id)
    {
        // Lấy sản phẩm có id bằng $id và trạng thái active = 1
        $product = Product::with('category')->findOrFail($id) // Chỉ lấy 1 sản phẩm // Đảm bảo rằng category được nạp cùng với product
// eager load relationship với category
            ->where('id', $id)
            ->where('active', 1)  // chỉ lấy sản phẩm đang active
            ->firstOrFail();  // Nếu không tìm thấy sẽ trả về lỗi 404
    
        return $product;
    }

    public function more($id)
    {
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->where('id', '!=', $id)
            ->orderByDesc('id')
            ->limit(8)
            ->get();
    }
}