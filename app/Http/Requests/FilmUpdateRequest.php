<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmUpdateRequest extends FormRequest
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
            "name" => "string",
            "description" => "string",
            "duration" => "integer",
            "age_limit" => "integer",
        ];
    }

    public function messages()
    {
        return [
            'name.string'       => 'Значение должно быть строкой',
            'description.string' => 'Значение должно быть строкой',
            'age_limit.integer' => 'Значение должно быть целым числом',
            'duration.integer'  => 'Значение должно быть целым числом',
        ];
    }
}
