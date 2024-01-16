<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionCreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "cost" => "required|numeric",
            "session_datetime" => "required||date_format:Y-m-d H:i:s|",
        ];
    }

    public function messages()
    {
        return [
            'cost.numeric'          => 'Значение должно быть числом',
            'session_datetime.date_format' => 'Значение должно быть датой и временем',
        ];
    }
}
