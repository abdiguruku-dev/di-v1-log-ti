@extends('layouts.admin_master')
@section('page_title', 'Master Mata Pelajaran')

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
                <div class="card-header bg-white fw-bold py-3">Tambah Mapel Baru</div>
                <div class="card-body">
                    <form action="{{ route('admin.mapel.store') }}" method="POST">
                        @csrf
                        
                        @if($autoJenjang)
                            <div class="mb-3 p-2 bg-light border rounded text-center">
                                <span class="small text-muted d-block">Jenjang Terpilih:</span>
                                <strong class="text-primary fs-5">{{ $autoJenjang }}</strong>
                                <input type="hidden" name="jenjang" value="{{ $autoJenjang }}">
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Untuk Jenjang</label>
                                <select name="jenjang" class="form-select" required>
                                    <option value="">- Pilih Jenjang -</option>
                                    <option value="SD">SD / MI</option>
                                    <option value="SMP">SMP / MTs</option>
                                    <option value="SMA">SMA / MA</option>
                                    <option value="SMK">SMK</option>
                                </select>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-4">
                                <label class="form-label small fw-bold text-muted">Kode</label>
                                <input type="text" name="kode_mapel" class="form-control" placeholder="MTK">
                                <small class="text-muted" style="font-size: 10px">Singkatan unik. Cth: <strong>PAI, MTK-A</strong></small>
                            </div>
                            <div class="col-8">
                                <label class="form-label small fw-bold text-muted">Nama Mapel Lengkap</label>
                                <input type="text" name="nama_mapel" class="form-control" placeholder="Contoh: Matematika" required>
                                <small class="text-muted" style="font-size: 10px">Nama resmi di Rapor.</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nama Ringkas (Rapor/Leger)</label>
                            <input type="text" name="nama_ringkas" class="form-control" placeholder="Contoh: MTK">
                            <small class="text-muted" style="font-size: 10px">
                                <i class="bi bi-info-circle"></i> Untuk tampilan tabel nilai di HP/Leger yang sempit.
                            </small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-8">
                                <label class="form-label small fw-bold text-muted">Kelompok (Posisi Rapor)</label>
                                <select name="kelompok" class="form-select">
                                    <option value="A">A (Nasional)</option>
                                    <option value="B">B (Kewilayahan)</option>
                                    <option value="C1">C1 (Dasar Bidang)</option>
                                    <option value="C2">C2 (Dasar Program)</option>
                                    <option value="C3">C3 (Kompetensi)</option>
                                    <option value="MULOK">Muatan Lokal</option>
                                </select>
                                <small class="text-muted" style="font-size: 10px">
                                    A=Wajib Nas, B=Seni/Orkes, C=Produktif SMK.
                                </small>
                            </div>
                            <div class="col-4">
                                <label class="form-label small fw-bold text-muted">No. Urut</label>
                                <input type="number" name="nomor_urut" class="form-control" value="100">
                                <small class="text-muted" style="font-size: 10px">1 = Paling Atas.</small>
                            </div>
                        </div>

                        <div class="mb-3 p-2 bg-light border rounded">
                            <label class="form-label small fw-bold text-primary">Khusus Jurusan (Opsional)</label>
                            <select name="jurusan_id" class="form-select">
                                <option value="">-- UMUM (Semua Jurusan) --</option>
                                @foreach($jurusans as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted d-block mt-1" style="font-size: 10px">
                                <i class="bi bi-exclamation-circle"></i> Pilih UMUM untuk mapel dasar (Agama, Indo, Inggris). Pilih Jurusan hanya untuk mapel produktif spesifik.
                            </small>
                        </div>

                        <button class="btn btn-primary w-100 fw-bold"><i class="bi bi-save me-2"></i> SIMPAN MAPEL</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">Daftar Mata Pelajaran {{ $autoJenjang ? "($autoJenjang)" : "" }}</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Kode</th>
                                    <th>Jenjang</th>
                                    <th>Nama Mapel</th>
                                    <th>Kelompok</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mapel as $m)
                                <tr>
                                    <td class="ps-4 small fw-bold text-muted">{{ $m->kode_mapel ?? '-' }}</td>
                                    <td><span class="badge bg-info text-dark">{{ $m->jenjang }}</span></td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $m->nama_mapel }}</span><br>
                                        @if($m->nama_jurusan)
                                            <span class="badge bg-light text-secondary border">Khusus: {{ $m->nama_jurusan }}</span>
                                        @else
                                            <small class="text-muted fst-italic">Mapel Umum</small>
                                        @endif
                                        @if($m->nama_ringkas)
                                            <br><small class="text-muted">Singkatan: {{ $m->nama_ringkas }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $m->kelompok }}</span> 
                                        <div class="small text-muted mt-1" style="font-size: 10px;">Urut: {{ $m->nomor_urut }}</div>
                                    </td>
                                    <td>
                                        @if($m->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Arsip</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $m->id }}"><i class="bi bi-pencil-square"></i></button>
                                        <a href="{{ route('admin.mapel.delete', $m->id) }}" class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalEdit{{ $m->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Edit Mapel</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.mapel.update') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id" value="{{ $m->id }}">
                                                <div class="modal-body">
                                                    
                                                    @if($autoJenjang)
                                                        <div class="mb-3 p-2 bg-light border rounded">
                                                            <span class="small text-muted">Jenjang:</span> 
                                                            <strong class="text-primary">{{ $autoJenjang }}</strong>
                                                            <input type="hidden" name="jenjang" value="{{ $autoJenjang }}">
                                                        </div>
                                                    @else
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Jenjang</label>
                                                            <select name="jenjang" class="form-select">
                                                                <option value="SD" {{ $m->jenjang == 'SD' ? 'selected' : '' }}>SD</option>
                                                                <option value="SMP" {{ $m->jenjang == 'SMP' ? 'selected' : '' }}>SMP</option>
                                                                <option value="SMA" {{ $m->jenjang == 'SMA' ? 'selected' : '' }}>SMA</option>
                                                                <option value="SMK" {{ $m->jenjang == 'SMK' ? 'selected' : '' }}>SMK</option>
                                                            </select>
                                                        </div>
                                                    @endif

                                                    <div class="row mb-3">
                                                        <div class="col-8">
                                                            <label class="form-label small fw-bold">Nama Mapel</label>
                                                            <input type="text" name="nama_mapel" class="form-control" value="{{ $m->nama_mapel }}" required>
                                                            <small class="text-muted" style="font-size: 10px">Nama lengkap di rapor.</small>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label small fw-bold">Kode</label>
                                                            <input type="text" name="kode_mapel" class="form-control" value="{{ $m->kode_mapel }}">
                                                            <small class="text-muted" style="font-size: 10px">ID Unik (MTK, PAI).</small>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-6">
                                                            <label class="form-label small fw-bold">Nama Ringkas</label>
                                                            <input type="text" name="nama_ringkas" class="form-control" value="{{ $m->nama_ringkas }}">
                                                            <small class="text-muted" style="font-size: 10px">Untuk tampilan tabel/HP.</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label small fw-bold">Kelompok</label>
                                                            <select name="kelompok" class="form-select">
                                                                <option value="A" {{ $m->kelompok == 'A' ? 'selected' : '' }}>A (Nasional)</option>
                                                                <option value="B" {{ $m->kelompok == 'B' ? 'selected' : '' }}>B (Kewilayahan)</option>
                                                                <option value="C1" {{ $m->kelompok == 'C1' ? 'selected' : '' }}>C1 (Dasar)</option>
                                                                <option value="C2" {{ $m->kelompok == 'C2' ? 'selected' : '' }}>C2 (Program)</option>
                                                                <option value="C3" {{ $m->kelompok == 'C3' ? 'selected' : '' }}>C3 (Komp)</option>
                                                                <option value="MULOK" {{ $m->kelompok == 'MULOK' ? 'selected' : '' }}>Muatan Lokal</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">No. Urut Rapor</label>
                                                        <input type="number" name="nomor_urut" class="form-control" value="{{ $m->nomor_urut }}">
                                                        <small class="text-muted" style="font-size: 10px">Semakin kecil, semakin atas posisinya.</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Khusus Jurusan</label>
                                                        <select name="jurusan_id" class="form-select">
                                                            <option value="">-- UMUM (Semua Jurusan) --</option>
                                                            @foreach($jurusans as $j)
                                                                <option value="{{ $j->id }}" {{ $m->jurusan_id == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Status Penggunaan</label>
                                                        <select name="is_active" class="form-select">
                                                            <option value="1" {{ $m->is_active ? 'selected' : '' }}>Aktif (Dipakai Sekarang)</option>
                                                            <option value="0" {{ !$m->is_active ? 'selected' : '' }}>Arsip / Sejarah</option>
                                                        </select>
                                                        <small class="text-muted" style="font-size: 10px">Pilih "Arsip" untuk mapel jadul agar tidak mengganggu guru.</small>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-warning fw-bold">UPDATE</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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