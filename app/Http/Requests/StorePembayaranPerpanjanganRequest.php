<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StorePembayaranPerpanjanganRequest extends FormRequest
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
            //
            'amount' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999', // Sesuaikan dengan batas maksimum yang Anda inginkan
            ],
            'payment_date' => 'required|date',
            'year' => [
                'required',
                'date_format:Y',
                Rule::unique('customer_pembayaran_perpanjangan')
                    ->where(function ($query) {
                        return $query->where('customer_id', $this->customer_id);
                    })
                    ->whereNull('deleted_at') // Tambahkan ini untuk mengabaikan data yang telah di-soft delete
                    ->ignore($this->id) // Tambahkan ini jika Anda sedang melakukan update
            ],
            'customer_id' => [
                'required',
                'integer',
                'exists:customer,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => ':attribute harus diisi.',
            'amount.numeric' => ':attribute harus berupa angka.',
            'amount.min' => ':attribute tidak boleh kurang dari 0.',
            'amount.max' => ':attribute terlalu besar.',
            'payment_date.required' => ':attribute harus diisi.',
            'payment_date.date' => 'Format :attribute tidak valid.',
            'year.required' => ':attribute harus diisi.',
            'year.date_format' => 'Format :attribute harus YYYY-MM-DD.',
            'year.unique' => ':attribute ini sudah ada untuk customer yang bersangkutan.',
            'customer_id.required' => ':attribute harus diisi.',
            'customer_id.integer' => ':attribute harus berupa angka bulat.',
            'customer_id.exists' => 'Customer dengan :attribute tersebut tidak ditemukan.',
        ];
    }

    public function attributes(): array
    {
        return [
            'amount' => 'Jumlah pembayaran',
            'payment_date' => 'Tanggal pembayaran',
            'year' => 'Tahun pembayaran',
            'customer_id' => 'ID Customer',
        ];
    }
}
