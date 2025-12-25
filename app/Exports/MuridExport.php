<?php

namespace App\Exports;

use App\Models\Murid;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MuridExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Murid::with(['kelas', 'jurusan'])->get();
    }

    public function headings(): array
    {
        // Judul Kolom di Excel Header
        return [
            'NIS', 'NISN', 'Nama Lengkap', 'L/P', 
            'Kelas', 'Jurusan', 'Status', 'Tanggal Masuk'
        ];
    }

    public function map($murid): array
    {
        // Data yang dimasukkan per baris
        return [
            $murid->nis,
            $murid->nisn,
            $murid->nama_lengkap,
            $murid->jenis_kelamin,
            $murid->kelas ? $murid->kelas->nama_kelas : '-',
            $murid->jurusan ? $murid->jurusan->nama_jurusan : '-',
            $murid->status_murid,
            $murid->created_at->format('d-m-Y'),
        ];
    }
}