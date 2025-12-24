@extends('layouts.admin_master')

@section('title')
    Data Unit Sekolah
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-primary fw-bold"><i class="bi bi-buildings"></i> Data Unit Sekolah (Yayasan)</h4>
        
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUnit">
            <i class="bi bi-plus-lg"></i> Tambah Unit Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Logo</th>
                            <th>Nama Unit & Alamat</th>
                            <th>Jenjang</th>
                            <th>Kepala Sekolah</th>
                            <th width="15%" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $unit)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($unit->logo)
                                    <img src="{{ asset('uploads/'.$unit->logo) }}" alt="Logo" class="rounded border" width="40" height="40" style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted border" style="width: 40px; height: 40px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $unit->nama_unit }}</div>
                                <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ Str::limit($unit->alamat_unit, 40) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $unit->jenjang }}</span>
                            </td>
                            <td>
                                <div>{{ $unit->kepala_sekolah }}</div>
                                <small class="text-muted">{{ $unit->nip_kepala_sekolah ?? '-' }}</small>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEditUnit{{ $unit->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                
                                <a href="{{ route('admin.sekolah.unit.delete', $unit->id) }}" class="btn btn-sm btn-outline-danger btn-delete" onclick="return confirm('Yakin hapus unit ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" width="60" class="mb-3 opacity-50">
                                <p class="mb-0">Belum ada unit sekolah yang ditambahkan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahUnit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Tambah Unit Sekolah</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.sekolah.unit.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Nama Unit Sekolah</label>
                            <input type="text" name="nama_unit" class="form-control" placeholder="Contoh: SD Islam Terpadu..." required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Jenjang</label>
                            <select name="jenjang" class="form-select" required>
                                <option value="">- Pilih -</option>
                                <option value="TK">TK / PAUD</option>
                                <option value="SD">SD / MI</option>
                                <option value="SMP">SMP / MTS</option>
                                <option value="SMA">SMA / MA</option>
                                <option value="SMK">SMK (3 Tahun)</option>
                                <option value="SMK 4 Tahun">SMK (4 Tahun)</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat_unit" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kepala Sekolah</label>
                            <input type="text" name="kepala_sekolah" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">NIP Kepsek</label>
                            <input type="text" name="nip_kepala_sekolah" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Logo Unit (Opsional)</label>
                            <input type="file" name="logo_unit" class="form-control">
                            <small class="text-muted">Format: JPG/PNG, Max 2MB.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Unit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($units as $unit)
<div class="modal fade" id="modalEditUnit{{ $unit->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning-subtle text-dark">
                <h5 class="modal-title fw-bold">Edit Unit: {{ $unit->nama_unit }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.sekolah.unit.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $unit->id }}">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Nama Unit Sekolah</label>
                            <input type="text" name="nama_unit" class="form-control" value="{{ $unit->nama_unit }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Jenjang</label>
                            <select name="jenjang" class="form-select" required>
                                <option value="TK" {{ $unit->jenjang == 'TK' ? 'selected' : '' }}>TK / PAUD</option>
                                <option value="SD" {{ $unit->jenjang == 'SD' ? 'selected' : '' }}>SD / MI</option>
                                <option value="SMP" {{ $unit->jenjang == 'SMP' ? 'selected' : '' }}>SMP / MTS</option>
                                <option value="SMA" {{ $unit->jenjang == 'SMA' ? 'selected' : '' }}>SMA / MA</option>
                                <option value="SMK" {{ $unit->jenjang == 'SMK' ? 'selected' : '' }}>SMK (3 Tahun)</option>
                                <option value="SMK 4 Tahun" {{ $unit->jenjang == 'SMK 4 Tahun' ? 'selected' : '' }}>SMK (4 Tahun)</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat_unit" class="form-control" rows="2">{{ $unit->alamat_unit }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kepala Sekolah</label>
                            <input type="text" name="kepala_sekolah" class="form-control" value="{{ $unit->kepala_sekolah }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">NIP Kepsek</label>
                            <input type="text" name="nip_kepala_sekolah" class="form-control" value="{{ $unit->nip_kepala_sekolah }}">
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Ganti Logo</label>
                            
                            <div class="d-flex align-items-center gap-3 mb-2">
                                @if($unit->logo)
                                    <div class="border p-1 rounded bg-white">
                                        <img src="{{ asset('uploads/'.$unit->logo) }}" alt="Logo Saat Ini" style="height: 50px; width: auto;">
                                    </div>
                                    <small class="text-success fw-bold"><i class="bi bi-check-circle"></i> Logo Terpasang</small>
                                @else
                                    <small class="text-muted fst-italic">Belum ada logo.</small>
                                @endif
                            </div>

                            <input type="file" name="logo_unit" class="form-control">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah logo.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold">Update Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection