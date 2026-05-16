<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Use middleware for role check
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'buying_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'variants' => 'required|array|min:1',
            'variants.*.size' => 'required|string|distinct',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.buying_price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'specifications' => 'nullable|array',
            'is_active' => 'boolean',
            'sizes' => 'nullable|string',
            'offer_price' => 'nullable|numeric|min:0',
            'offer_discount_percentage' => 'nullable|integer|min:0|max:100',
            'offer_start_date' => 'nullable|date',
            'offer_end_date' => 'nullable|date|after_or_equal:offer_start_date',
        ];

        if ($this->isMethod('post') || $this->isMethod('put') || $this->isMethod('patch')) {
            $rules['images.*'] = 'image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }

        return $rules;
    }
}
