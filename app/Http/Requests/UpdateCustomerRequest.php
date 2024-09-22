<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
        // return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'birthday' => 'sometimes|required|date',
            'gender' => 'sometimes|required|in:male,female',
            'email' => 'sometimes|required|email|unique:customer,email,' . $this->customer->id,
            // 'email' => [
            //     'sometimes',
            //     'required',
            //     'email',
            //     Rule::unique('customer')->where(function ($query) {
            //         return $query->whereNull('deleted_at');
            //     })->ignore($this->customer->id),
            // ],
            'phone' => [
                'sometimes',
                'required',
                'string',
                'regex:/^([0-9\s\-\+\(\)]*)$/', // Validasi format nomor telepon
                'min:10',
                'max:20',
                Rule::unique('customer')->ignore($this->customer->id), // Memastikan unik kecuali untuk record ini sendiri,
                // Rule::unique('customer')->where(function ($query) {
                //     return $query->whereNull('deleted_at');
                // })->ignore($this->customer->id),  // Memastikan unik kecuali untuk record ini sendiri dalam mode soft delete
            ],
            'address' => 'sometimes|required|string',
            'city' => 'sometimes|required|string|max:100',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute harus diisi.',
            'name.max' => ':attribute tidak boleh lebih dari 255 karakter.',
            'birthday.required' => ':attribute harus diisi.',
            'birthday.date' => 'Format :attribute tidak valid.',
            'gender.required' => ':attribute harus dipilih.',
            'gender.in' => ':attribute yang dipilih tidak valid.',
            'email.required' => ':attribute harus diisi.',
            'email.email' => 'Format :attribute tidak valid.',
            'email.unique' => ':attribute sudah digunakan.',
            'phone.required' => ':attribute harus diisi.',
            'phone.max' => ':attribute tidak boleh lebih dari 20 karakter.',
            'phone.regex' => 'Format :attribute tidak valid',
            'address.required' => ':attribute harus diisi.',
            'city.required' => ':attribute harus diisi.',
            'city.max' => 'Nama :attribute tidak boleh lebih dari 100 karakter.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'email' => 'Alamat Email',
            'phone' => 'Nomor Telepon',
            'birthday' => 'Tanggal Lahir',
            'gender' => 'Jenis Kelamin',
            'address' => 'Alamat',
            'city' => 'Kota'
        ];
    }
}
