<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address' => 'required|string',
            'payment_method' => 'required|in:cod,online', // Add more as needed
            'notes' => 'nullable|string|max:500',
        ];
    }
}
