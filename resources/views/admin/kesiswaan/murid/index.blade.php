@extends('layouts.admin_master')

@section('title', 'Data Murid')

@section('content')
<div class="container-fluid">

    {{-- 1. HEADING HALAMAN --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Data Murid</h1>
    </div>

    {{-- 2. NOTIFIKASI SYSTEM (ALERT) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <strong class="d-block mb-2"><i class="bi bi-exclamation-octagon-fill me-2"></i> Error Import:</strong>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 3. CARD UTAMA --}}
    <div class="card shadow mb-4">
        
        {{-- HEADER --}}
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">
                <i class="bi bi-table me-1"></i> Daftar Semua Murid
            </h6>
        </div>

        {{-- BODY --}}
        <div class="card-body">
            
            {{-- A. TOOLBAR --}}
            <div class="row g-2 mb-4 align-items-center justify-content-between">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.murid.create') }}" class="btn btn-sm btn-success shadow-sm px-3">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Data
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-success shadow-sm" data-bs-toggle="modal" data-bs-target="#importExcel">
                            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Import
                        </button>
                        <a href="{{ route('admin.murid.template') }}" class="btn btn-sm btn-info text-white shadow-sm">
                            <i class="bi bi-download me-1"></i> Format
                        </a>
                        <div class="btn-group shadow-sm">
                            <button type="button" class="btn btn-sm btn-warning dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Export
                            </button>
                            <ul class="dropdown-menu shadow animated--fade-in">
                                <li><h6 class="dropdown-header">Pilih Format:</h6></li>
                                <li><a class="dropdown-item" href="{{ route('admin.murid.export_excel') }}"><i class="bi bi-file-earmark-excel text-success me-2"></i> Ke Excel</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.murid.export_pdf') }}" target="_blank"><i class="bi bi-file-earmark-pdf text-danger me-2"></i> Ke PDF</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <form action="{{ route('admin.murid.index') }}" method="GET">
                        <div class="input-group input-group-sm shadow-sm">
                            <input type="text" name="keyword" class="form-control bg-light border-0 small" placeholder="Cari Nama / NIS..." value="{{ request('keyword') }}">
                            <button class="btn btn-success" type="submit"><i class="bi bi-search"></i></button>
                            @if(request('keyword'))
                            <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary" title="Reset"><i class="bi bi-x-circle"></i></a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- B. ALERT HASIL PENCARIAN --}}
            @if(request('keyword'))
                <div class="alert alert-success py-2 mb-3 small">
                    <i class="bi bi-info-circle me-1"></i> Hasil pencarian: <strong>"{{ request('keyword') }}"</strong>.
                    <a href="{{ route('admin.murid.index') }}" class="alert-link ms-2">Reset</a>
                </div>
            @endif

            {{-- C. TABEL DATA --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0" style="border-color: #e3e6f0;">
                    <thead class="table-light text-dark" style="background-color: #f8f9fc;">
                        <tr class="text-center">
                            <th width="5%" class="align-middle">No</th>
                            <th class="align-middle">NIS</th>
                            <th class="align-middle">Foto</th>
                            <th class="align-middle" width="30%">Nama Lengkap</th> {{-- Lebarkan dikit buat progress bar --}}
                            <th class="align-middle">Kelas</th>
                            <th class="align-middle">L/P</th>
                            <th class="align-middle">Status</th>
                            <th width="10%" class="align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($murids as $index => $murid)
                        <tr class="align-middle bg-white">
                            {{-- NOMOR --}}
                            <td class="text-center">{{ $index + 1 + ($murids->currentPage() - 1) * $murids->perPage() }}</td>
                            
                            {{-- NIS --}}
                            <td class="text-center font-weight-bold text-secondary">{{ $murid->nis ?? '-' }}</td>
                            
                            {{-- FOTO --}}
                            <td class="text-center">
                                @if($murid->foto)
                                    <img src="{{ asset('storage/'.$murid->foto) }}" class="rounded-circle border" width="35" height="35" style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle border d-inline-flex align-items-center justify-content-center text-secondary" style="width: 35px; height: 35px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                @endif
                            </td>
                            
                            {{-- NAMA & PROGRESS BAR (SUDAH DIPERBAIKI LOGIKANYA) --}}
                            <td>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">{{ $murid->nama_lengkap ?? 'Tanpa Nama' }}</span>
                                    @if(!$murid->nama_lengkap) <small class="text-danger fst-italic ms-2">(Draft)</small> @endif
                                </div>

                                {{-- LOGIC PROGRESS BAR FIXED --}}
                                @php
                                    $step = $murid->input_progress ?? 0;
                                    
                                    // PERBAIKAN: Max Step jadi 8 sesuai Wizard Boss
                                    $maxStep = 8; 
                                    
                                    $percent = ($step / $maxStep) * 100;
                                    if($percent > 100) $percent = 100;
                                    
                                    // Warna Bar (Logic Baru)
                                    $barColor = 'bg-secondary';
                                    if($percent > 12) $barColor = 'bg-danger';   // Step 1-2 (Merah)
                                    if($percent > 37) $barColor = 'bg-warning';  // Step 3-4 (Kuning)
                                    if($percent > 62) $barColor = 'bg-info';     // Step 5-6 (Biru)
                                    if($percent >= 100) $barColor = 'bg-success';// Selesai (Hijau)
                                @endphp

                                <div class="mt-1">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span style="font-size: 0.65rem;" class="text-muted">Kelengkapan Data: {{ round($percent) }}%</span>
                                    </div>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar {{ $barColor }}" role="progressbar" 
                                             style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- KELAS --}}
                            <td class="text-center">
                                @if($murid->kelas)
                                    <span class="badge bg-primary bg-opacity-75 rounded-pill px-3">{{ $murid->kelas->nama_kelas }}</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3">Belum Masuk</span>
                                @endif
                            </td>

                            {{-- L/P --}}
                            <td class="text-center">{{ $murid->jenis_kelamin }}</td>

                            {{-- STATUS --}}
                            <td class="text-center">
                                <span class="badge {{ ($murid->status_murid == 'Aktif') ? 'bg-success' : 'bg-danger' }} rounded-pill px-3">
                                    {{ $murid->status_murid ?? 'Draft' }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td class="text-center">
                                <x-action-buttons 
                                    :show="route('admin.murid.show', $murid->id)"
                                    :edit="route('admin.murid.edit', $murid->id)"
                                    :delete="route('admin.murid.destroy', $murid->id)"
                                    :name="$murid->nama_lengkap"
                                />
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <h6 class="fw-bold mt-2">Data murid belum tersedia</h6>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 4. PAGINATION --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $murids->links() }}
            </div>

        </div> 
    </div> 

</div>

{{-- 5. MODAL IMPORT EXCEL --}}
<div class="modal fade" id="importExcel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{ route('admin.murid.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-spreadsheet me-1"></i> Import Data Murid</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info small">
                        <strong>Tips:</strong> Gunakan template yang disediakan. Kosongkan NIS jika ingin otomatis.
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih File Excel (.xlsx)</label>
                        <input type="file" name="file" class="form-control" required accept=".xlsx, .xls">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // A. Notifikasi SweetAlert
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}" });
    @endif
    @if($errors->any())
        Swal.fire({ icon: 'warning', title: 'Periksa Kembali', html: '<ul class="text-start">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>' });
    @endif

    // B. Script Konfirmasi Hapus
    $(document).on('submit', '.form-delete', function(e) {
        e.preventDefault();
        var form = this;
        var nama = $(this).data('name');
        Swal.fire({
            title: 'Hapus Data?',
            text: nama + " akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
</script>
@endpush