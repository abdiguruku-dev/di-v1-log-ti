@extends('layouts.admin_master')
@section('page_title', 'Tahun Ajaran')

@section('content')
<div class="container-fluid">

    @if(session('error'))
    <   div class="alert alert-danger border-0 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif



    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Baru
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tahun_ajaran.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">Tahun Pelajaran</label>
                            <input type="text" name="tahun_ajaran" class="form-control" placeholder="Contoh: 2024/2025" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">Semester</label>
                            <select name="semester" class="form-select">
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold">SIMPAN</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-list-ul me-2"></i> Daftar Tahun Ajaran
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4">Tahun</th>
                                    <th>Semester</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tahun_ajaran as $ta)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $ta->tahun_ajaran }}</td>
                                    <td>{{ $ta->semester }}</td>
                                    <td>
                                        @if($ta->is_active)
                                            <span class="badge bg-success px-3"><i class="bi bi-check-circle me-1"></i> AKTIF</span>
                                        @else
                                            <span class="badge bg-secondary opacity-50">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$ta->is_active)
                                            <a href="{{ route('admin.tahun_ajaran.activate', $ta->id) }}" class="btn btn-sm btn-outline-success" title="Aktifkan">
                                                <i class="bi bi-power"></i>
                                            </a>
                                            <a href="{{ route('admin.tahun_ajaran.delete', $ta->id) }}" class="btn btn-sm btn-outline-danger btn-delete"  title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-light text-muted" disabled><i class="bi bi-lock"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @if($tahun_ajaran->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada data tahun ajaran.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection