@extends('layouts.admin_master')
@section('page_title', 'Tambah Murid')

@section('content')
<div class="container-fluid">

    {{-- BAGIAN TOMBOL KEMBALI DI ATAS SUDAH DIHAPUS --}}

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong class="d-block mb-1">Gagal Menyimpan Data!</strong>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Data Diri</h6>
        </div>
        <div class="card-body">
            
            {{-- Form start --}}
            <form action="{{ route('admin.murid.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" placeholder="Contoh: Ahmad Dahlan">
                            @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">NIS</label>
                                    <input type="number" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}">
                                    @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">NISN</label>
                                    <input type="number" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}">
                                    @error('nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                <option value="">- Pilih -</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Kelas <span class="text-danger">*</span></label>
                            <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                                <option value="">- Pilih Kelas -</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            @error('kelas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Jurusan (Opsional)</label>
                            <select name="jurusan_id" class="form-control">
                                <option value="">- Pilih Jurusan -</option>
                                @foreach($jurusans as $j)
                                    <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }} ({{ $j->kode_jurusan }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nama Ibu Kandung <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu') }}">
                            @error('nama_ibu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Foto Murid</label>
                            
                            <div class="mb-2 text-center">
                                <img id="fotoPreview" src="#" alt="Preview Foto" 
                                    style="display: none; width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 3px solid #1cc88a; margin: 0 auto;">
                            </div>

                            <input type="file" name="foto" id="fotoInput" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                            
                            <small class="text-muted">Format: jpg, png, jpeg. Maks: 2MB</small>
                            @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <hr>
                
                {{-- AREA TOMBOL: KEMBALI (KIRI) & SIMPAN (KANAN) --}}
                <div class="d-flex justify-content-between">
                    
                    {{-- Tombol Kembali --}}
                    <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>

                    {{-- Tombol Simpan --}}
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save mr-1"></i> Simpan Data
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
@endsection