<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class StoreDanaPelunasanRequest extends FormRequest
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
            'dana_dp_id' => [
                'required',
                'integer',
                'exists:customer_dana_dp,id',
            ],
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => ':attribute dana pelunasan harus diisi.',
            'amount.numeric' => ':attribute dana pelunasan harus berupa angka.',
            'amount.min' => ':attribute dana pelunasan tidak boleh kurang dari 0.',
            'amount.max' => ':attribute dana pelunasan terlalu besar.',
            'dana_dp_id.required' => ':attribute harus diisi.',
            'dana_dp_id.integer' => ':attribute harus berupa angka bulat.',
            'dana_dp_id.exists' => ':attribute tersebut tidak ditemukan.',
        ];
    }

    public function attributes(): array
    {
        return [
            'amount' => 'Jumlah',
            'dana_dp_id' => 'Dana DP ID',
        ];
    }
}
