<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryRepository;

    public function __construct(ProductService $productService, CategoryRepository $categoryRepository)
    {
        $this->productService = $productService;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $categoryId = $request->get('category_id');
        if ($categoryId && !is_numeric($categoryId)) {
            $categoryId = \App\Helpers\HashIdHelper::decode($categoryId);
        }

        $filters = [
            'name' => $request->get('search'),
            'category_id' => $categoryId,
            'active_only' => true
        ];

        // If category is passed as slug (common in public links)
        if ($request->has('category') && !is_numeric($request->get('category'))) {
            $cat = \App\Models\Category::where('slug', $request->get('category'))->first();
            if ($cat) {
                $filters['category_id'] = $cat->id;
            }
        }

        $products = $this->productService->searchProducts($filters);
        
        // Apply sorting
        $sort = $request->get('sort', 'newest');
        $products = $this->applySorting($products, $sort);
        
        $categories = $this->categoryRepository->getAllCategories();
        
        return view('frontend.products.index', compact('products', 'categories'));
    }

    private function applySorting($products, $sort)
    {
        switch ($sort) {
            case 'price_low':
                return $products->sortBy('price');
            case 'price_high':
                return $products->sortByDesc('price');
            case 'name_asc':
                return $products->sortBy('name');
            case 'name_desc':
                return $products->sortByDesc('name');
            case 'newest':
            default:
                return $products->sortByDesc('created_at');
        }
    }

    public function show($slug)
    {
        $product = $this->productService->getProductBySlug($slug);
        return view('frontend.products.show', compact('product'));
    }
}
