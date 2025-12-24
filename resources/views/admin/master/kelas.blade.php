@extends('layouts.admin_master')
@section('page_title', 'Master Data Kelas')

@section('content')
{{-- Simpan data jenjang di input hidden agar bisa dibaca JavaScript --}}
<input type="hidden" id="config_jenjang" value="{{ $jenjangSekolah }}">

<div class="container-fluid">

    {{-- 1. ERROR VALIDASI (KOTAK MERAH DENGAN LIST) --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-octagon-fill fs-4 me-3"></i>
                <div>
                    <strong class="d-block mb-1">Gagal Menyimpan Data!</strong>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 2. ERROR MANUAL (DARI CONTROLLER) --}}
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 3. SUKSES (HIJAU) --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold py-3">Tambah Kelas Baru</div>
                <div class="card-body">
                    <form action="{{ route('admin.kelas.store') }}" method="POST" id="form-kelas">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Tingkat / Jenjang</label>
                            <select name="tingkat" id="tingkat_select" class="form-select" required>
                                <option value="">-- Pilih Tingkat --</option>

                                {{-- SD: Muncul jika jenjang SD, MI, atau TERPADU --}}
                                @if(in_array($jenjangSekolah, ['SD', 'MI', 'TERPADU']))
                                    <optgroup label="Jenjang SD / MI">
                                        @for($i=1; $i<=6; $i++) 
                                            <option value="{{ $i }}">Kelas {{ $i }}</option> 
                                        @endfor
                                    </optgroup>
                                @endif

                                {{-- SMP: Muncul jika jenjang SMP, MTS, atau TERPADU --}}
                                @if(in_array($jenjangSekolah, ['SMP', 'MTS', 'TERPADU']))
                                    <optgroup label="Jenjang SMP / MTs">
                                        @for($i=7; $i<=9; $i++) 
                                            <option value="{{ $i }}">Kelas {{ $i }}</option> 
                                        @endfor
                                    </optgroup>
                                @endif

                                {{-- SMA/SMK: Muncul jika jenjang SMA, SMK, MA, atau SMK (Program 4 Tahun) --}}
                                @if(in_array($jenjangSekolah, ['SMA', 'SMK', 'MA', 'SMK (Program 4 Tahun)', 'TERPADU']))
                                    <optgroup label="Jenjang Menengah (SMA/SMK/MA)">
                                    @for($i=10; $i<=13; $i++) 
                                        @if($i == 13 && $jenjangSekolah != 'SMK (Program 4 Tahun)')
                                            @continue
                                        @endif
                                        <option value="{{ $i }}">
                                            Kelas {{ $i }} 
                                            @if($i == 10) (X)
                                            @elseif($i == 11) (XI)
                                            @elseif($i == 12) (XII)
                                            @elseif($i == 13) (XIII)
                                            @endif
                                        </option> 
                                    @endfor
                                    </optgroup>
                                @endif
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Jurusan</label>
                            
                            {{-- LOGIKA CERDAS: Cek jumlah jurusan yang tersedia --}}
                            @if($jurusans->count() == 1)
                                {{-- SKENARIO 1: Jurusan cuma satu (SD/SMP) --}}
                                {{-- Kita ambil data pertama, lalu kunci (readonly) --}}
                                @php $singleJurusan = $jurusans->first(); @endphp
                                
                                <input type="hidden" name="jurusan_id" value="{{ $singleJurusan->id }}">
                                <input type="text" class="form-control bg-light" value="{{ $singleJurusan->nama_jurusan }} - {{ $singleJurusan->kode_jurusan }}" readonly>
                                <small class="text-muted">Otomatis terpilih sesuai jenjang sekolah.</small>

                            @elseif($jurusans->count() > 1)
                                {{-- SKENARIO 2: Jurusan banyak (SMA/SMK) --}}
                                {{-- Tampilkan Dropdown --}}
                                <select name="jurusan_id" class="form-select @error('jurusan_id') is-invalid @enderror">
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach($jurusans as $j)
                                        <option value="{{ $j->id }}">{{ $j->nama_jurusan }} ({{ $j->kode_jurusan }})</option>
                                    @endforeach
                                </select>
                                @error('jurusan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            @else
                                {{-- SKENARIO 3: Data Kosong (Belum input Master Jurusan) --}}
                                <div class="alert alert-warning py-2 small">
                                    <i class="bi bi-exclamation-triangle"></i> Data Jurusan untuk jenjang <b>{{ $jenjangSekolah }}</b> belum ada. 
                                    Silakan ke menu <b>Master Jurusan</b> untuk membuatnya terlebih dahulu.
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama Kelas (Label)</label>
                            <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: X-TKJ-1, 7A, 1-B" >
                        </div>

                        {{-- Input Hidden Otomatis untuk SD/SMP agar data terkirim meski select di-disable --}}
                        @if($jenjangSekolah == 'SD' || $jenjangSekolah == 'SMP')
                            @foreach($jurusans as $j)
                                @if(str_contains(strtolower($j->nama_jurusan), 'umum'))
                                    <input type="hidden" name="jurusan_id" value="{{ $j->id }}">
                                @endif
                            @endforeach
                        @endif

                        <button type="submit" class="btn btn-primary w-100">SIMPAN KELAS</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">Daftar Kelas</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Tingkat</th>
                                <th>Nama Kelas</th>
                                <th>Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelas as $k)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-info text-dark rounded-pill">Kelas {{ $k->tingkat }}</span>
                                </td>
                                <td class="fw-bold fs-5 text-primary">{{ $k->nama_kelas }}</td>
                                <td>{{ $k->nama_jurusan }}</td>
                                <td>
                                    <a href="{{ route('admin.kelas.delete', $k->id) }}" class="btn btn-sm btn-outline-danger btn-delete" ><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @if($kelas->isEmpty())
                            <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada data kelas untuk jenjang ini.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pages/master-kelas.js') }}"></script>
@endpush