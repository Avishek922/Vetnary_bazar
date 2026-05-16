<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Repositories\CategoryRepository;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryRepo;

    public function __construct(ProductService $productService, CategoryRepository $categoryRepo)
    {
        $this->productService = $productService;
        $this->categoryRepo = $categoryRepo;
    }

    public function index(Request $request)
    {
        $categoryId = $request->get('category_id');
        if ($categoryId && !is_numeric($categoryId)) {
            $categoryId = \App\Helpers\HashIdHelper::decode($categoryId);
        }

        $filters = [
            'name' => $request->get('search'),
            'category_id' => $categoryId
        ];

        $products = $this->productService->searchProducts($filters);
        $categories = $this->categoryRepo->getAllCategories();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = $this->categoryRepo->getAllCategories();
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        try {
            $this->productService->createProduct($request->validated(), $request->file('images', []));
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $categories = $this->categoryRepo->getAllCategories();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            $this->productService->updateProduct($product->id, $request->validated(), $request->file('images', []));
            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product->id);
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
