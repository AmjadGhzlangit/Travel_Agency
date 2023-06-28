<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'priceFrom' => 'numeric',
            'priceTo' => 'numeric',
            'dateFrom' => 'date',
            'dateTo' => 'date',
            'sortBy' => Rule::in(['price']),
            'orderBy' => Rule::in(['asc', 'desc']),
        ];
    }

    public function messages(): array
    {
        return [
            'priceFrom' => "The 'priceFrom' parameter accepts only 'numeric' values ",
            'priceTo' => "The 'priceTo' parameter accepts only 'numeric' values ",
            'dateFrom' => "The 'dateFrom' parameter accepts only 'date' values ",
            'dateTo' => "The 'dateTo' parameter accepts only  values ",
            'sortBy' => "The 'sortBy' parameter accepts only 'price' values ",
            'orderBy' => "The 'orderBy' parameter accepts only 'asc' or 'desc' values ",
        ];
    }
}
