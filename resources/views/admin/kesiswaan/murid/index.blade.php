@extends('layouts.admin_master')
@section('page_title', 'Data Murid Aktif')

@section('content')
<div class="container-fluid">
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-white">Daftar Murid</h6>
            
            <div class="d-flex gap-2"> <a href="{{ route('admin.murid.create') }}" class="btn btn-orange btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Murid
                </a>

                <button type="button" class="btn btn-yellow btn-sm" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Import Via Excel
                </button>

                <a href="{{ route('admin.murid.template') }}" class="btn btn-purple btn-sm">
                    <i class="bi bi-download"></i> Download Format
                </a>

            </div>
        </div>

        <div class="card-body">
            {{-- MULAI GANTI DARI SINI --}}
            
            {{-- 1. Alert Sukses --}}
            @if(session('success'))
                <x-alert type="success">
                    {{ session('success') }}
                </x-alert>
            @endif

            {{-- 2. Alert Error (Manual dari Controller) --}}
            @if(session('error'))
                <x-alert type="error">
                    {{ session('error') }}
                </x-alert>
            @endif

            {{-- 3. Alert Validasi (Jika ada error import excel dsb) --}}
            @if ($errors->any())
                <x-alert type="error">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>NIS</th>
                            <th class="text-center">Foto</th><th>Nama Lengkap</th>
                            <th>Kelas</th>
                            <th>L/P</th>
                            <th>Status</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($murids as $key => $murid)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            
                            <td><span class="badge badge-light border">{{ $murid->nis }}</span></td>

                            <td class="text-center">
                                @if($murid->foto)
                                    <img src="{{ asset('storage/' . $murid->foto) }}" alt="Foto" class="table-avatar">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($murid->nama_lengkap) }}&background=random&color=fff&size=64" alt="Foto" class="table-avatar">
                                @endif
                            </td>
                            <td class="font-weight-bold text-dark">{{ $murid->nama_lengkap }}</td>
                            <td>{{ $murid->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $murid->jenis_kelamin }}</td>
                            <td>
                                <span class="badge badge-success px-2 py-1">Aktif</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.murid.edit', $murid->id) }}" class="btn btn-warning btn-sm btn-circle" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.murid.destroy', $murid->id) }}" method="POST" class="d-inline form-delete" data-name="{{ $murid->nama_lengkap }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon-action btn-icon-delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center p-5">
                                <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-536.jpg" alt="No Data" style="width: 150px; opacity: 0.6;">
                                <p class="text-muted mt-3 font-weight-bold">Belum ada data murid.</p>
                                <small class="text-gray-500">Silakan tambah manual atau import excel.</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{-- $murids->links() --}} 
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            
            <div class="modal-header border-0 bg-gradient-primary-to-secondary" style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);">
                <h5 class="modal-title text-white font-weight-bold" id="importExcelLabel">
                    <i class="bi bi-file-earmark-spreadsheet-fill me-2"></i> Import Data Murid
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.murid.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    
                    <div class="alert alert-info d-flex align-items-center" role="alert" style="background: rgba(54, 185, 204, 0.1); border: 1px solid rgba(54, 185, 204, 0.3); color: #36b9cc;">
                        <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                        <div>
                            <small class="fw-bold">Pastikan file sesuai format!</small><br>
                            <span style="font-size: 0.8rem;">Hanya file <b>.xlsx</b> atau <b>.xls</b> yang diperbolehkan.</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="fileExcel" class="form-label fw-bold text-gray-700">Pilih File Excel</label>
                        
                        <input type="file" name="file" class="form-control form-control-lg" id="fileExcel" 
                               accept=".xlsx, .xls" required 
                               style="border: 2px solid #1cc88a; border-radius: 10px; padding: 10px;">
                        
                        <div class="form-text mt-2 text-muted">
                            Maksimal ukuran file: 2MB.
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-yellow text-white shadow-sm">
                        <i class="bi bi-upload me-1"></i> Upload Sekarang
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
    // Tidak perlu jQuery lagi untuk modal, Bootstrap 5 mengurusnya otomatis.
    // Kita hanya butuh listener sederhana jika ingin validasi tambahan di sisi klien (opsional)
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Halaman Murid Siap - Bootstrap 5 Active');
    });
</script>
@endpush

<script>
    $(document).ready(function() {
        // 1. Paksa Modal muncul saat tombol Import diklik
        $('[data-target="#importModal"]').click(function(e) {
            e.preventDefault();
            $('#importModal').modal('show');
        });

        // 2. SOLUSI LAYAR HITAM: Paksa hapus backdrop saat modal ditutup
        // Script ini akan berjalan setiap kali modal disembunyikan (hidden)
        $('#importModal').on('hidden.bs.modal', function () {
            // Hapus paksa elemen layar hitam
            $('.modal-backdrop').remove();
            
            // Hapus class yang membuat body tidak bisa discroll
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
        });

        // 3. Tambahan: Tombol "Batal" dan "X" juga memicu penutupan manual
        $('.close, .btn-secondary').click(function() {
            $('#importModal').modal('hide');
        });

        // Agar nama file muncul di input type file custom bootstrap
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });
</script>
@endsection