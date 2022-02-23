<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidationLaporan extends FormRequest
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
            'month' => 'required|numeric|min:1|max:12',
            'year'  => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'month.required'=> 'Mohon tentukan Bulan sesuai dengan pilihan',
            'month.numeric' => 'Silahkan isi Bulan Dengan Benar',
            'month.min'     => 'Silahkan isi Bulan Dengan Benar',
            'month.max'     => 'Silahkan isi Bulan Dengan Benar',
            'year.required' => 'Mohon tentukan Tahun sesuai dengan pilihan',
            'year.numeric'  => 'Silahkan isi Tahun Dengan Benar',
            'year.min'      => 'Silahkan isi Tahun Dengan Benar',
        ];
    }
}
