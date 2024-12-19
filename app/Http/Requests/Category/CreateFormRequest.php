<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'thumb' => 'required'
        ];
    }
    public function messages() : array
    {
        return [
            'name.required' => 'Vui lòng nhập tên Danh Mục',
            'name.thumb' =>  'Vui lòng chọn ảnh đại diện'
        ];
    }
}
