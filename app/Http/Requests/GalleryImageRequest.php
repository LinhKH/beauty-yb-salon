<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalleryImageRequest extends FormRequest
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
            'title' => 'required|unique:gallery_image,title',
            'description' => 'required',
            'category' => 'required',
        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules = [
                'title' => 'required',Rule::unique('gallery_image','title')->ignore($this->id),
                'description'=>'required',
                'category'=>'required',
                'status'=>'required',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'This name is already Exists',
            'description.required' => 'Gallery Image Description is required',
            'category.required' => 'Gallery Image Category is required',
            'status.required' => 'Gallery Image Status is required',
        ];
    }
}
