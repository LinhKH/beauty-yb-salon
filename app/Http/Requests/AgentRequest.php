<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgentRequest extends FormRequest
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
            'name' => 'required|unique:agents,name',
            'service' => 'required',
            'experience' => 'required',
           // 'booking' => 'required',
        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules = [
                'name' => 'required',Rule::unique('agents','name')->ignore($this->id),
                'service' => 'required',
                'experience' => 'required',
              //  'booking' => 'required',
                'status'=>'required',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'This name is already Exists',
            'service.required' => 'Agent Service is required',
            'experience.required' => 'Agent Experience is required',
           // 'booking.required' => 'Agent Total Booking is required',
            'status.required' => 'Agent Status is required',
        ];
    }
}
