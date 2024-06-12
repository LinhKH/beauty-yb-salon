<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TimeSlotRequest extends FormRequest
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
            'from_time' => 'required|unique:time_slot,from_time',
            'to_time' => 'required',
        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules = [
                'from_time' => 'required',Rule::unique('time_slot','from_time')->ignore($this->id),
                'to_time' => 'required', 
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'from_time.required' => 'This Time Slot is already Exists',
            'to_time.required' => 'To Time Slot is required',
        ];
    }
}
