{{-- File: resources/views/components/alert.blade.php --}}
@props(['type' => 'success'])

@php
    // Logika: Jika tipe error jadi merah, jika success jadi hijau
    $bgClass = $type == 'error' ? 'bg-danger text-white' : 'bg-success text-white';
    $icon = $type == 'error' ? 'bi-exclamation-octagon-fill' : 'bi-check-circle-fill';
@endphp

<div class="alert {{ $bgClass }} border-0 shadow-sm alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center">
        <i class="bi {{ $icon }} fs-4 me-3"></i>
        <div class="w-100">
            {{-- $slot adalah tempat teks atau list error akan muncul --}}
            {{ $slot }}
        </div>
    </div>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
</div>