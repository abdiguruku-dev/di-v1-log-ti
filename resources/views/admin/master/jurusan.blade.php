@extends('layouts.admin_master')
@section('page_title', 'Master Jurusan / Kompetensi')

@section('content')
<input type="hidden" id="config_jenjang" value="{{ $jenjangSekolah }}">
<div class="container-fluid">
    
    {{-- 1. Menampilkan Error Validasi (Dari StoreJurusanRequest) --}}
    @if ($errors->any())
        <x-alert type="error">
            <strong class="d-block mb-1">Gagal Menyimpan Data!</strong>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    {{-- 2. Menampilkan Pesan Sukses --}}
    @if(session('success'))
        <x-alert type="success">
            {{ session('success') }}
        </x-alert>
    @endif

    {{-- 3. Menampilkan Pesan Error Manual (Controller) --}}
    @if(session('error'))
        <x-alert type="error">
            {{ session('error') }}
        </x-alert>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">Tambah Jurusan</div>
                <div class="card-body">
                    <form action="{{ route('admin.jurusan.store') }}" method="POST" id="form-jurusan">
                        @csrf
                        <input type="hidden" name="_method" id="method_field" value="POST">
                        <input type="hidden" name="jenjang" value="{{ $jenjangSekolah }}">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Pilih Jenjang</label>
                            <select name="jenjang" id="jenjang_select" class="form-control" required>
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="SD">SD / MI</option>
                                <option value="SMP">SMP / MTs</option>
                                <option value="SMA">SMA / MA</option>
                                <option value="SMK">SMK (3 Tahun)</option>
                                <option value="SMK 4 Tahun">SMK (4 Tahun)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Kode</label>
                            <input type="text" name="kode_jurusan" id="kode_jurusan" class="form-control" placeholder="Contoh: IPA, TKJ" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama Jurusan</label>
                            <input type="text" name="nama_jurusan" id="nama_jurusan" class="form-control" placeholder="Contoh: Teknik Komputer Jaringan" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Keterangan</label>
                            <textarea name="keterangan" class="form-control"></textarea>
                        </div>
                        
                        <button class="btn btn-primary w-100">SIMPAN</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Kode</th>
                                <th>Nama Jurusan</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jurusans as $j)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $j->kode_jurusan }}</td>
                                <td>{{ $j->nama_jurusan }}</td>
                                <td class="text-muted small">{{ $j->keterangan }}</td>
                                <td class="text-center">
                                    @php
                                        $isDefault = \Illuminate\Support\Str::contains($j->kode_jurusan, 'UMUM');
                                    @endphp

                                    @if($isDefault)
                                        <span class="badge bg-secondary">Default</span>
                                    @else
                                        {{-- TOMBOL EDIT (Kuning, Icon Only, Tanpa Garis Bawah) --}}
                                        <a href="javascript:void(0)"
                                        class="text-warning me-2 edit-btn"
                                        style="font-size: 1rem; cursor: pointer; text-decoration: none;"
                                        data-id="{{ $j->id }}"
                                        data-kode="{{ $j->kode_jurusan }}"
                                        data-nama="{{ $j->nama_jurusan }}"
                                        data-jenjang="{{ $j->jenjang }}"
                                        data-ket="{{ $j->keterangan }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- TOMBOL DELETE (Merah, Icon Only, Tanpa Garis Bawah) --}}
                                        <a href="{{ route('admin.jurusan.delete', $j->id) }}"
                                        class="text-danger btn-delete"
                                        style="font-size: 1rem; cursor: pointer; text-decoration: none;">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/pages/master-jurusan.js') }}"></script>

    {{-- Load SweetAlert dari CDN (Internet) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- LOGIKA EDIT ---
        const editBtns = document.querySelectorAll('.edit-btn');
        const form = document.getElementById('form-jurusan');
        const methodField = document.getElementById('method_field');
        
        // Ambil elemen input
        const inputKode = document.querySelector('input[name="kode_jurusan"]');
        const inputNama = document.querySelector('input[name="nama_jurusan"]');
        const inputKet  = document.querySelector('textarea[name="keterangan"]');
        // Jika ada input jenjang, ambil juga
        
        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // 1. Ambil data dari tombol
                let id = this.getAttribute('data-id');
                let kode = this.getAttribute('data-kode');
                let nama = this.getAttribute('data-nama');
                let ket = this.getAttribute('data-ket');

                // 2. Isi ke dalam Form
                if(inputKode) inputKode.value = kode;
                if(inputNama) inputNama.value = nama;
                if(inputKet) inputKet.value = ket;

                // 3. UBAH PERILAKU FORM (Dari Simpan Baru -> Jadi Update)
                // Ganti URL Action agar mengarah ke route Update
                // Asumsi route update anda formatnya: admin/master/jurusan/{id}
                let baseAction = "{{ route('admin.jurusan.store') }}"; // URL dasar
                // Kita potong 'store' dan ganti dengan ID (sesuaikan dengan route resource Laravel Anda)
                // Jika route update Anda beda, sesuaikan string ini.
                // Cara paling aman biasanya replace 'store' dengan 'update/' + id jika manual
                form.action = baseAction.replace('store', 'update/' + id); 
                
                // Ubah Method jadi PUT
                methodField.value = 'PUT';

                // 4. Ubah Judul Tombol/Card (Opsional, visual saja)
                const submitBtn = form.querySelector('button[type="submit"]');
                if(submitBtn) submitBtn.innerText = 'Update Data';

                // 5. Fokus ke input pertama
                if(inputKode) inputKode.focus();
            });
        });

        // --- LOGIKA DELETE (SweetAlert) ---
        const deleteBtns = document.querySelectorAll('.btn-delete');
        
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault(); // Cegah browser pindah halaman langsung
                const url = this.getAttribute('href'); // Ambil link delete

                // Tampilkan Popup Cantik
                Swal.fire({
                    title: 'Yakin hapus data ini?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user klik Ya, baru kita buka link delete
                        window.location.href = url;
                    }
                });
            });
        });
    });
</script>
@endpush

@endsection



