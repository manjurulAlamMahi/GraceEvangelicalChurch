<?php

namespace App\Http\Controllers\Web\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use apiresponse;
    // Category
    public function category(Request $request)
    {
        $query = Category::query();

        $categories = $query->where('status', 'active')->select('id', 'name', 'image')->get();
        $categories->map(function ($cate) {
            $cate->image = asset($cate->image);
            return $cate;
        });

        return $this->success($categories, 'Successfully!', 200);
    }
}
