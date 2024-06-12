<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
            'title' => 'required|unique:services,title',
            'price' => 'required',
            'duration' => 'required',
        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules = [
                'title' => 'required',Rule::unique('services','title')->ignore($this->id),
                'price' => 'required',
                'duration' => 'required',
                'status'=>'required',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'This name is already Exists',
            'price.required' => 'Service Price is required',
            'duration.required' => 'Service Duration is required',
            'status.required' => 'Service Status is required',
        ];
    }
}
