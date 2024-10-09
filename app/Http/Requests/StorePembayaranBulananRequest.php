<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StorePembayaranBulananRequest extends FormRequest
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
            'period' => [
                'required',
                'date_format:Y-m-d',
                Rule::unique('customer_pembayaran_bulanan')
                    ->where(function ($query) {
                        return $query->where('customer_id', $this->customer_id);
                    })
            ],
            'customer_id' => [
                'required',
                'integer',
                'exists:customer,id',
            ],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('period')) {
            $this->merge([
                'period' => Carbon::createFromFormat('M/Y', $this->period)->startOfMonth()->format('Y-m-d'),
            ]);
        }
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
            'period.required' => ':attribute harus diisi.',
            'period.date_format' => 'Format :attribute harus YYYY-MM-DD.',
            'period.unique' => ':attribute ini sudah ada untuk customer yang bersangkutan.',
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
            'period' => 'Periode pembayaran',
            'customer_id' => 'ID Customer',
        ];
    }
}
