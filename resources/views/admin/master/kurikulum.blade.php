@extends('layouts.admin_master')
@section('page_title', 'Master Kurikulum & Sejarah')

@section('content')
<div class="container-fluid">

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">
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
                <div class="card-header bg-white fw-bold py-3">Tambah Data Kurikulum</div>
                <div class="card-body">
                    <form action="{{ route('admin.kurikulum.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama Kurikulum</label>
                            <input type="text" name="nama_kurikulum" class="form-control" placeholder="Contoh: Kurikulum 1994" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">Tahun Mulai</label>
                                <input type="number" name="tahun_mulai" class="form-control" placeholder="1994" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">Skala Nilai</label>
                                <select name="skala_nilai" class="form-select">
                                    <option value="0-100">0 - 100</option>
                                    <option value="0-10">0 - 10</option>
                                    <option value="0-4">0 - 4.0</option>
                                    <option value="HURUF">Huruf (A-E)</option>
                                </select>
                            </div>
                        </div>

                        <div class="p-3 mb-3 bg-light border rounded">
                            <h6 class="small fw-bold text-primary mb-2">Sistem Periode (Waktu)</h6>
                            <div class="mb-2">
                                <label class="small text-muted">Sebutan Periode</label>
                                <input type="text" name="label_periode" class="form-control form-control-sm" placeholder="Contoh: Semester / Caturwulan" value="Semester" required>
                            </div>
                            <div class="mb-0">
                                <label class="small text-muted">Jumlah per Tahun</label>
                                <input type="number" name="jumlah_periode" class="form-control form-control-sm" value="2" min="1" max="12" required>
                                <small class="text-muted" style="font-size: 10px">Isi 2 untuk Semester, 3 untuk Caturwulan.</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Upload Dokumen Asli (PDF)</label>
                            <input type="file" name="dokumen" class="form-control">
                            <small class="text-muted" style="font-size: 10px">Scan dokumen kurikulum (Arsip Sejarah).</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2"></textarea>
                        </div>
                        <button class="btn btn-primary w-100"><i class="bi bi-save me-2"></i> SIMPAN DATA</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">Arsip Kurikulum</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Tahun</th>
                                    <th>Nama Kurikulum</th>
                                    <th>Sistem Periode</th>
                                    <th>Skala</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
    @foreach($kurikulum as $k)
    <tr>
        <td class="ps-4 text-muted fw-bold">{{ $k->tahun_mulai }}</td>
        
        <td>
            <div class="fw-bold text-dark fs-6">{{ $k->nama_kurikulum }}</div>
            
            @if($k->dokumen_pendukung)
                <a href="{{ asset('storage/'.$k->dokumen_pendukung) }}" target="_blank" class="badge bg-danger bg-opacity-10 text-danger text-decoration-none border border-danger mt-1">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Lihat Dokumen Asli
                </a>
            @else
                <small class="text-muted fst-italic" style="font-size: 11px;">- Tidak ada dokumen -</small>
            @endif
        </td>

        <td>
            <span class="fw-bold text-primary">{{ $k->label_periode }}</span>
            <br>
            <small class="text-muted">{{ $k->jumlah_periode }}x setahun</small>
        </td>

        <td><span class="badge bg-info text-dark">{{ $k->skala_nilai }}</span></td>
        
        <td>
            @if($k->is_active)
                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Aktif</span>
            @else
                <span class="badge bg-secondary">Non-Aktif</span>
            @endif
        </td>
        
        <td>
            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $k->id }}" title="Edit">
                <i class="bi bi-pencil-square"></i>
            </button>
            <a href="{{ route('admin.kurikulum.delete', $k->id) }}" class="btn btn-sm btn-outline-danger btn-delete" title="Hapus">
                <i class="bi bi-trash"></i>
            </a>
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
</div>
@endsection