<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
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
            'title' => 'required|min:5|max:50|unique:types',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Заглавие типа не может быть пустым',
            'title.min'      => 'Минимальная длина заглавия 5 символов',
            'title.max'      => 'Максимальная длина заглавия 50 символов',
            'title.unique'   => 'Тип с таким заглавием уже существует',
        ];
    }
}
