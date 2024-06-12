<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
        $rules = [
            'title' => 'required|unique:pages,page_title',
        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules = [
                'title' => 'required',Rule::unique('pages','page_title')->ignore($this->id),
                'slug'=>'required',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'This name is already Exists',
            'slug.required' => 'Page Slug Name is required',
        ];
    }
}
