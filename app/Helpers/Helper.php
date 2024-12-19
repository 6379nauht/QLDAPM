<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Helper
{
    /**
     * Render category table rows recursively.
     *
     * @param Collection $categories
     * @param int $parent_id
     * @param string $char
     * @return string
     */
    public static function Category($categories, $parent_id = 0, $char = ''): string
    {
        $html = '';

        foreach ($categories as $key => $category) {
            if ($category->parent_id == $parent_id) {
                $html .= '
                <tr id="category-row-' . $category->id . '">
                    <td>' . $category->id . '</td>
                    <td>' . $char . $category->name . '</td>
                                    <td>
                        <img src="' . asset($category->thumb) . '" alt="' . $category->name . '" style="max-width: 100px; max-height: 100px;">
                    </td>
                    <td>' . self::active($category->active) . '</td>
                    <td>' . $category->updated_at . '</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="' . route('admin.category.edit', ['category' => $category->id]) . '">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . route('admin.category.destroy', ['category' => $category->id]) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Bạn có chắc chắn muốn xóa danh mục này?\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>';

                unset($categories[$key]);

                $html .= self::Category($categories, $category->id, $char . '|--');
            }
        }

        return $html;
    }

    /**
     * Generate status HTML.
     *
     * @param int $active
     * @return string
     */
    public static function active($active = 0): string
    {
        return $active == 0
            ? '<span class="btn btn-danger btn-xs">NO</span>'
            : '<span class="btn btn-success btn-xs">YES</span>';
    }




    public static function categories(Collection $categories, int $parent_id = 0): string
{
    Log::info('Generating categories for parent_id: ' . $parent_id);

    $html = '';
    $children = self::getChildren($categories, $parent_id);

    if ($children->isNotEmpty()) {
        foreach ($children as $child) {
            $html .= '<li>';
            $html .= '<a href="/danh-muc/' . $child['id'] . '-' . Str::slug($child['name'], '-') . '.html">';
            $html .= $child['name'] . '</a>';

            // Đệ quy để lấy danh mục con của danh mục hiện tại
            $subChildren = self::getChildren($categories, $child['id']);
            if ($subChildren->isNotEmpty()) {
                $html .= '<ul class="sub-menu">';
                $html .= self::categories($categories, $child['id']);
                $html .= '</ul>';
            }

            $html .= '</li>';
        }
    } else {
        Log::info('No children found for parent_id: ' . $parent_id);
    }

    return $html;
}

/**
 * Get children categories based on parent_id.
 *
 * @param Collection $categories
 * @param int $parent_id
 * @return Collection
 */
public static function getChildren(Collection $categories, int $parent_id): Collection
{
    Log::info('Checking for children of parent_id: ' . $parent_id);

    // Lọc các danh mục có parent_id bằng với parent_id hiện tại
    $children = $categories->filter(function($category) use ($parent_id) {
        return $category['parent_id'] == $parent_id;
    });

    // Log ra số lượng danh mục con tìm được
    Log::info('Found children: ' . $children->count(), $children->toArray());

    return $children;
}

    

    /**
     * Display price with formatting or a default message.
     *
     * @param int $price
     * @param int $priceSale
     * @return string
     */
    public static function price($price = 0, $priceSale = 0): string
    {
        if ($priceSale != 0) return number_format($priceSale) . ' đ';
        if ($price != 0) return number_format($price) . ' đ';
        return '<a href="/lien-he.html">Liên Hệ</a>';
    }
}
