<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreDanaDPRequest extends FormRequest
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
            'dana_komitmen_id' => [
                'required',
                'integer',
                'exists:customer_dana_komitmen,id',
            ],
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => ':attribute dana dp harus diisi.',
            'amount.numeric' => ':attribute dana dp harus berupa angka.',
            'amount.min' => ':attribute dana dp tidak boleh kurang dari 0.',
            'amount.max' => ':attribute dana dp terlalu besar.',
            'customer_dana_komitmen.required' => ':attribute harus diisi.',
            'customer_dana_komitmen.integer' => ':attribute harus berupa angka bulat.',
            'customer_dana_komitmen.exists' => ':attribute tersebut tidak ditemukan.',
        ];
    }

    public function attributes(): array
    {
        return [
            'amount' => 'Jumlah',
            'customer_dana_komitmen' => 'Dana Komitmen ID',
        ];
    }
}
