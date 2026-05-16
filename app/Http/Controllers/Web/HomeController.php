<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $categoryRepo;
    protected $productRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo, ProductRepositoryInterface $productRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryRepo->getRootCategories();
        
        $filters = [
            'name' => $request->get('search'),
            'category_id' => $request->get('category_id'),
            'active_only' => true
        ];

        // Handle category from slug if coming from category links
        if ($request->has('category')) {
            $cat = \App\Models\Category::where('slug', $request->get('category'))->with('children')->first();
            if ($cat) {
                // Get all category IDs including subcategories
                $categoryIds = $cat->getAllCategoryIds();
                $filters['category_ids'] = $categoryIds;
                unset($filters['category_id']); // Remove single category_id filter
            }
        }

        $featuredProducts = $this->productRepo->searchProducts($filters);

        // Limit to 8 products on homepage when no filters are applied
        if (!$request->hasAny(['search', 'category_id', 'category'])) {
            $featuredProducts = $featuredProducts->take(8);
        }

        // Apply sorting
        $sort = $request->get('sort', 'newest');
        $featuredProducts = $this->applySorting($featuredProducts, $sort);

        // Fetch team members
        $teamMembers = \App\Models\TeamMember::active()->ordered()->get();

        // Fetch Offer Products
        $now = now();
        $offerProducts = \App\Models\Product::where('is_active', true)
            ->where(function($query) {
                $query->where(function($q) {
                    $q->whereNotNull('offer_price')->where('offer_price', '>', 0);
                })->orWhere(function($q) {
                     $q->whereNotNull('offer_discount_percentage')->where('offer_discount_percentage', '>', 0);
                });
            })
            ->where(function ($query) use ($now) {
                $query->where(function ($q) use ($now) {
                    $q->whereNull('offer_start_date')->orWhere('offer_start_date', '<=', $now);
                })->where(function ($q) use ($now) {
                    $q->whereNull('offer_end_date')->orWhere('offer_end_date', '>=', $now);
                });
            })->take(4)->get();

        return view('frontend.home', compact('categories', 'featuredProducts', 'teamMembers', 'offerProducts'));
    }

    private function applySorting($products, $sort)
    {
        switch ($sort) {
            case 'price_low':
                return $products->sortBy('price')->values();
            case 'price_high':
                return $products->sortByDesc('price')->values();
            case 'name_asc':
                return $products->sortBy('name')->values();
            case 'name_desc':
                return $products->sortByDesc('name')->values();
            case 'newest':
            default:
                return $products->sortByDesc('created_at')->values();
        }
    }
}
