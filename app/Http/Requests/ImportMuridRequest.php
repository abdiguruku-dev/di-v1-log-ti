<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportMuridRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Hanya izinkan file Excel (xlsx, xls)
            'file' => 'required|file|mimes:xlsx,xls|max:5120', // Max 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Silakan pilih file Excel terlebih dahulu.',
            'file.mimes'    => 'Format file harus Excel (.xlsx atau .xls).',
            'file.max'      => 'Ukuran file maksimal 5MB.',
        ];
    }
}
