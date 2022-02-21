<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidationUser extends FormRequest
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
            'name'     => 'required|string|between:5,50',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles'    => 'required|numeric|between:1,2'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Nama Pegawai harus wajib di-isi',
            'name.between'          => 'Panjang Nama Pegawai minimal 5 maksimal 50',
            'name.string'           => 'Mohon di isi Nama Pegawai dengan benar',
            'email.required'        => 'Email harus wajib di-isi',
            'email.email'           => 'Format Email salah',
            'email.unique'          => 'Email ini sudah terdaftar',
            'password.required'     => 'Mohon Di isi bagian password',
            'password.string'       => 'Mohon di isi Nama Pegawai dengan benar',
            'password.min'          => 'Minimal panjang password 8 karakter',
            'password.confirmed'    => 'Konfrimasi Password harus benar dan sama',
            'roles.required'         => 'Mohon dipilih untuk jabatannya',
            'roles.numeric'          => 'Jabatan yang dipilih salah num',
            'roles.between'          => 'Jabatan yang dipilih salah btwn',
        ];
    }

    public function response(array $errors)
    {
        return response()->json(['message' => $errors], 400);
    }
}
