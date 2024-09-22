<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreDanaKomitmenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999', // Sesuaikan dengan batas maksimum yang Anda inginkan
            ],
            'customer_id' => [
                'required',
                'integer',
                'exists:customer,id',
            ],
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => ':attribute dana komitmen harus diisi.',
            'amount.numeric' => ':attribute dana komitmen harus berupa angka.',
            'amount.min' => ':attribute dana komitmen tidak boleh kurang dari 0.',
            'amount.max' => ':attribute dana komitmen terlalu besar.',
            'customer_id.required' => ':attribute harus diisi.',
            'customer_id.integer' => ':attribute harus berupa angka bulat.',
            'customer_id.exists' => ':attribute tersebut tidak ditemukan.',
        ];
    }

    public function attributes(): array
    {
        return [
            'amount' => 'Jumlah',
            'customer_id' => 'Customer ID',
        ];
    }
}
