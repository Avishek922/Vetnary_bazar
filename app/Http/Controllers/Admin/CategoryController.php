<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryRepositoryInterface;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Str;
use App\Services\FileUploadService;

class CategoryController extends Controller
{
    protected $categoryRepo;
    protected $fileUploadService;

    public function __construct(CategoryRepositoryInterface $categoryRepo, FileUploadService $fileUploadService)
    {
        $this->categoryRepo = $categoryRepo;
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $categories = $this->categoryRepo->getAllCategories();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = $this->categoryRepo->getRootCategories();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        // Check for duplicate slug
        $existing = \App\Models\Category::where('slug', $data['slug'])->first();
        if ($existing) {
             $data['slug'] = $data['slug'] . '-' . time();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->fileUploadService->upload($request->file('image'), 'categories');
        }

        $this->categoryRepo->createCategory($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
    }

    public function edit(\App\Models\Category $category)
    {
        $parentCategories = $this->categoryRepo->getRootCategories()->where('id', '!=', $category->id);
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(CategoryRequest $request, \App\Models\Category $category)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        // Check for duplicate slug excluding current id
        $existing = \App\Models\Category::where('slug', $data['slug'])->where('id', '!=', $category->id)->first();
        if ($existing) {
             $data['slug'] = $data['slug'] . '-' . time();
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                $this->fileUploadService->delete($category->image);
            }
            $data['image'] = $this->fileUploadService->upload($request->file('image'), 'categories');
        }

        $this->categoryRepo->updateCategory($category->id, $data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(\App\Models\Category $category)
    {
        if ($category->image) {
            $this->fileUploadService->delete($category->image);
        }
        $this->categoryRepo->deleteCategory($category->id);
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }
}
