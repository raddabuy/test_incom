<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionUpdateRequest extends FormRequest
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
            "film_id" => "integer",
            "cost" => "numeric",
            "session_datetime" => "datetime",
        ];
    }

    public function messages()
    {
        return [
            'film_id.integer'       => 'Значение должно быть целым числом',
            'cost.numeric'          => 'Значение должно быть числом',
            'session_datetime.date' => 'Значение должно быть датой и временем',
        ];
    }
}
