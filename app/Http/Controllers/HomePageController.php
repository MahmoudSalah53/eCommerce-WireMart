<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HomePageSetting;
use App\Models\Product;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $homepagesetting = HomePageSetting::with([
            'discountedProduct.images',
            'featuredProduct1.images',
            'featuredProduct2.images',
        ])->first();
        return view('home.index', compact('homepagesetting'));
    }

    public function about()
    {
        return view ('home.about');
    }

    public function terms()
    {
        return view ('home.terms');
    }

    public function showAllProducts(Request $request)
    {
        $products = Product::with('category', 'images')->latest()->get();
        $query = Product::query()->with('images', 'category')->where('status', 'Published');


        if ($request->has('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        // التصفية بالفئة
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // الترتيب
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('regular_price');
                break;
            case 'price_desc':
                $query->orderByDesc('regular_price');
                break;
            case 'newest':
                $query->orderByDesc('created_at');
                break;
            case 'popular':
                // يمكنك إضافة منطق الأكثر مبيعاً هنا
                $query->withCount('orders')->orderByDesc('orders_count');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('products.all', compact('products', 'categories'));
    }

    public function showCategory($id)
{
    $category = Category::findOrFail($id);
    $products = Product::where('category_id', $id)->paginate(12);
    
    return view('products.all', [
        'products' => $products,
        'categories' => Category::all(),
        'currentCategory' => $category
    ]);
}

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}
