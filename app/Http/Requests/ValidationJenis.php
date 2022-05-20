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
            'code' => 'required|string|between:4,10',
            'name' => 'required|string|between:4,50',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Kode jenis harus wajib di-isi',
            'code.string'   => 'Mohon di isi Kode Jenis dengan benar',
            'code.between'  => 'Panjang Kode Jenis minimal 5, maksimal 50',
            'name.required' => 'Mohon di isi bagian Nama jenis',
            'name.string'   => 'Mohon di isi Nama Jenis dengan benar',
            'name.between'  => 'Panjang nama minimal 5, maksimal 50',
        ];
    }

    public function response(array $errors) {
        return response()->json(['message' => $errors]);
    }
}
