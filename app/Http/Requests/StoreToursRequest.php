<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreToursRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'starting_date' => ['required', 'date'],
            'ending_date' => ['required', 'date', 'after:starting_date'],
            'price' => ['required', 'numeric'],
        ];
    }
}
