<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJurusanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_jurusan' => 'required|string|max:10|unique:jurusans,kode_jurusan',
            'nama_jurusan' => 'required|string|max:100',
            'jenjang'      => ['required', Rule::in(['SD', 'SMP', 'SMA', 'SMK', 'MI', 'MTS', 'MA', 'MAK'])],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_jurusan.required' => 'Kode Jurusan wajib diisi.',
            'kode_jurusan.unique'   => 'Kode Jurusan ini sudah ada. Gunakan kode lain.',
            'nama_jurusan.required' => 'Nama Jurusan wajib diisi.',
            'jenjang.required'      => 'Jenjang wajib dipilih.',
            'jenjang.in'            => 'Pilihan jenjang tidak valid.',
        ];
    }
}