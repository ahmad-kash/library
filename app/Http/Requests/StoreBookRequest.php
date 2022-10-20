<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'min:3'],
            'language' => ['required', 'string', 'size:2'],
            'author' => ['required', 'string'],
            'publisher' => ['required', 'string'],
            'category' => ['required', 'string'],
            'numberOfPages' => ['required', 'numeric'],
            'numberOfAvailableBooks' => ['required', 'numeric'],
            'sellingPrice' => ['required', 'numeric'],
            'rentingPrice' => ['required', 'numeric'],
            'coverPhoto' => [
                'required',
                File::image()
                    // ->min(1024)
                    ->max(20 * 1024)
                    ->dimensions(Rule::dimensions()->maxWidth(1000)->maxHeight(500)),
            ]
        ];
    }
}
