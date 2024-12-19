<?php


namespace App\Http\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{
    protected $users;

    public function __construct()
    {
    }

    public function compose(View $view)
    {
        // Lấy danh mục từ cơ sở dữ liệu
        $categories = Category::select('id', 'name', 'parent_id')
                              ->where('active', 1)
                              ->orderByDesc('id')
                              ->get();

        // Truyền danh mục vào view
        $view->with('categories', $categories);
    }
}
