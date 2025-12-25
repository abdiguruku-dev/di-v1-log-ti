@props([
    'type' => 'submit', // Jenis tombol (simpan, tambah, kembali, dll)
    'label' => null,    // Tulisan di tombol (bisa dikosongkan jika mau icon saja)
    'url' => null,      // Jika diisi, jadi link <a>. Jika kosong, jadi <button>
    'target' => '_self' // _blank untuk tab baru
])

@php
    // === KAMUS KONSISTENSI ===
    // Mengatur Ikon, Warna (Class), dan Label Default di satu tempat.
    // Tujuannya agar seluruh aplikasi seragam.
    
    $configs = [
        // 1. AKSI DASAR
        'simpan'   => ['icon' => 'bi bi-save',           'class' => 'btn-primary',   'def_label' => 'Simpan'],
        'tambah'   => ['icon' => 'bi bi-plus-circle',    'class' => 'btn-primary',   'def_label' => 'Tambah Data'],
        'edit'     => ['icon' => 'bi bi-pencil-square',  'class' => 'btn-warning',   'def_label' => 'Edit'],
        'hapus'    => ['icon' => 'bi bi-trash',          'class' => 'btn-danger',    'def_label' => 'Hapus'],
        'batal'    => ['icon' => 'bi bi-x-circle',       'class' => 'btn-danger',    'def_label' => 'Batal'],
        'kembali'  => ['icon' => 'bi bi-arrow-left',     'class' => 'btn-secondary', 'def_label' => 'Kembali'],
        'cari'     => ['icon' => 'bi bi-search',         'class' => 'btn-info text-white', 'def_label' => 'Cari'],
        
        // 2. FILE & REPORT
        'upload'   => ['icon' => 'bi bi-cloud-upload',   'class' => 'btn-info text-white', 'def_label' => 'Upload'],
        'download' => ['icon' => 'bi bi-cloud-download', 'class' => 'btn-success',   'def_label' => 'Download'],
        'print'    => ['icon' => 'bi bi-printer',        'class' => 'btn-dark',      'def_label' => 'Cetak'],
        'excel'    => ['icon' => 'bi bi-file-earmark-spreadsheet', 'class' => 'btn-success', 'def_label' => 'Export Excel'],
        'pdf'      => ['icon' => 'bi bi-file-earmark-pdf', 'class' => 'btn-danger',  'def_label' => 'Export PDF'],
        
        // 3. FITUR SISTEM
        'setting'    => ['icon' => 'bi bi-gear',           'class' => 'btn-secondary', 'def_label' => 'Pengaturan'],
        'filter'     => ['icon' => 'bi bi-funnel',         'class' => 'btn-light border', 'def_label' => 'Filter'],
        'hamburger'  => ['icon' => 'bi bi-list',           'class' => 'btn-light',     'def_label' => 'Menu'],
        'home'       => ['icon' => 'bi bi-house-door',     'class' => 'btn-primary',   'def_label' => 'Home'],
        'notifikasi' => ['icon' => 'bi bi-bell',           'class' => 'btn-warning',   'def_label' => 'Notifikasi'],
        'bantuan'    => ['icon' => 'bi bi-question-circle','class' => 'btn-info text-white', 'def_label' => 'Bantuan'],
        'akun'       => ['icon' => 'bi bi-person-circle',  'class' => 'btn-primary',   'def_label' => 'Akun Saya'],
        
        // 4. MODUL SEKOLAH (Khusus ERP)
        'uang'     => ['icon' => 'bi bi-cash-stack',     'class' => 'btn-success',   'def_label' => 'Keuangan'],
        'jadwal'   => ['icon' => 'bi bi-calendar-week',  'class' => 'btn-info text-white', 'def_label' => 'Jadwal'],
        'nilai'    => ['icon' => 'bi bi-journal-check',  'class' => 'btn-primary',   'def_label' => 'Penilaian'],
        'guru'     => ['icon' => 'bi bi-person-badge',   'class' => 'btn-info text-white', 'def_label' => 'Data Guru'],
        'orangtua' => ['icon' => 'bi bi-people',         'class' => 'btn-warning',   'def_label' => 'Orang Tua'],
        'whatsapp' => ['icon' => 'bi bi-whatsapp',       'class' => 'btn-success',   'def_label' => 'Kirim WA'],
    ];

    // Ambil config berdasarkan type, atau fallback ke default jika tipe tidak ditemukan
    $cfg = $configs[$type] ?? ['icon' => '', 'class' => 'btn-secondary', 'def_label' => ''];
    
    // Tentukan Label Akhir (Gunakan label custom jika ada, jika tidak pakai default)
    $finalLabel = $label ?? $cfg['def_label'];
@endphp

{{-- LOGIKA UTAMA --}}
@if($url)
    {{-- Jika ada URL, render sebagai Tag <a> (Link) --}}
    <a href="{{ $url }}" target="{{ $target }}" {{ $attributes->merge(['class' => 'btn btn-sm ' . $cfg['class']]) }}>
        @if($cfg['icon']) <i class="{{ $cfg['icon'] }} me-1"></i> @endif {{ $finalLabel }}
    </a>
@else
    {{-- Jika tidak ada URL, render sebagai Tag <button> --}}
    {{-- Tipe submit otomatis jika type='simpan', selain itu jadi type='button' --}}
    <button type="{{ $type == 'simpan' ? 'submit' : 'button' }}" {{ $attributes->merge(['class' => 'btn btn-sm ' . $cfg['class']]) }}>
        @if($cfg['icon']) <i class="{{ $cfg['icon'] }} me-1"></i> @endif {{ $finalLabel }}
    </button>
@endif