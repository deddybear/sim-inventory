<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidationJenis extends FormRequest
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
            'id'   => 'required|string|between:4,10|unique:types',
            'name' => 'required|string|between:4,50|unique:types',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Kode jenis harus wajib di-isi',
            'id.string'   => 'Mohon di isi Kode Jenis dengan benar',
            'id.between'  => 'Panjang Kode Jenis minimal 5, maksimal 50',
            'id.unique'   => 'Kode Jenis Sudah Terdaftar',
            'name.required' => 'Mohon di isi bagian Nama jenis',
            'name.string'   => 'Mohon di isi Nama Jenis dengan benar',
            'name.between'  => 'Panjang nama minimal 5, maksimal 50',
            'name.unique'   => 'Nama Jenis Sudah Terdaftar'
        ];
    }

    public function response(array $errors) {
        return response()->json(['message' => $errors]);
    }
}
