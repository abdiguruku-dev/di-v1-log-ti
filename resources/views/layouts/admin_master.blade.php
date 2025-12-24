<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
    // LOGIKA PHP: Mengambil data user & config
    $config = DB::table('sekolah_configs')->first();
    $mode = session('mode_aplikasi', $config->mode_aplikasi ?? 'TUNGGAL');
    $namaSekolah = $config->nama_sekolah ?? 'SchoolPRO';
    $namaAplikasi = $config->nama_aplikasi ?? 'Sistem Manajemen Sekolah';

    $logoApp = 'https://ui-avatars.com/api/?name='.urlencode($namaSekolah).'&background=random&color=fff&size=128&bold=true';
    if (!empty($config->logo)) {
    $logoApp = asset('uploads/'.$config->logo);
    }
    $userPhoto = 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0D6EFD&color=fff';
    @endphp

    <title>{{ $namaSekolah }} - {{ $namaAplikasi }}</title>
    <link rel="icon" href="{{ $logoApp }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('css/custom.css') }}?v={{ time() }}" rel="stylesheet">
    
</head>

<body>

    <div id="wrapper">
        {{-- PANGGIL SIDEBAR --}}
        @include('layouts.partials.sidebar') {{-- Memanggil file menu samping (kiri) --}}

        <div id="page-content-wrapper">

            {{-- PANGGIL TOPBAR --}}
            @include('layouts.partials.topbar') {{-- Memanggil file header atas (profil user) --}}

            <div class="container-fluid pb-5 flex-grow-1">
                @yield('content') {{-- Tempat konten halaman berubah-ubah --}}
            </div>

            {{-- PANGGIL FOOTER --}}
            @include('layouts.partials.footer') {{-- Memanggil file copyright paling bawah --}}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/custom-admin.js') }}?v={{ time() }}"></script>

    @stack('scripts') 
</body>
</html>