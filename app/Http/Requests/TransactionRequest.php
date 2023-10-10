<?php

namespace App\Http\Requests;

use App\Provider;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the provider is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'selected_date' => [
                'required', 'date_format:Y-m-d'
            ],
        ];
    }
}
