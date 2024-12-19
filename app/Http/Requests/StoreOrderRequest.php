<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
        // Cho phép tất cả các yêu cầu từ người dùng (sau này có thể thay đổi nếu cần)
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|regex:/^0[0-9]{9}$/', // Kiểm tra số điện thoại hợp lệ
            'email' => 'required|email|max:255', // Kiểm tra email hợp lệ
            'address' => 'required|string|max:500',
            'content' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên khách hàng là bắt buộc.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'address.required' => 'Địa chỉ là bắt buộc.',
        ];
    }
}
