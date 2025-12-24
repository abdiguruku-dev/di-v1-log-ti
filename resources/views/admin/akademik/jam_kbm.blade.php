@extends('layouts.admin_master')
@section('page_title', 'Master Jam KBM')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white border rounded shadow-sm">
        <div class="d-flex align-items-center gap-3">
            <span class="fw-bold text-muted small">JADWAL TERPILIH:</span>
            <div class="dropdown">
                <button class="btn btn-outline-primary btn-sm dropdown-toggle fw-bold text-uppercase" type="button" data-bs-toggle="dropdown">
                    {{ $currentCategory->nama_jadwal }}
                </button>
                <ul class="dropdown-menu shadow-sm">
                    @foreach($categories as $cat)
                        <li>
                            <a class="dropdown-item d-flex justify-content-between {{ $selectedId == $cat->id ? 'active' : '' }}" 
                               href="{{ route('admin.jam_kbm.index', ['kategori_id' => $cat->id]) }}">
                                {{ $cat->nama_jadwal }}
                                @if($cat->is_aktif) <i class="bi bi-check-circle-fill text-success ms-2"></i> @endif
                            </a>
                        </li>
                    @endforeach
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item fw-bold text-primary" href="#" data-bs-toggle="modal" data-bs-target="#modalAddCategory">
                            <i class="bi bi-plus-circle me-1"></i> Buat Jadwal Baru
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        @if($currentCategory->is_aktif)
            <span class="badge bg-success py-2 px-3"><i class="bi bi-check-circle me-1"></i> JADWAL SEDANG AKTIF</span>
        @else
            <form action="{{ route('admin.jam_kbm.activate') }}" method="POST" class="m-0">
                @csrf
                <input type="hidden" name="id" value="{{ $currentCategory->id }}">
                <button type="submit" class="btn btn-warning btn-sm fw-bold shadow-sm">
                    <i class="bi bi-toggle-on me-1"></i> AKTIFKAN JADWAL INI
                </button>
            </form>
        @endif
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-plus-circle me-2 text-primary"></i> Tambah Jam
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jam_kbm.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kategori_id" value="{{ $selectedId }}">

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Jam Ke-</label>
                            <input type="number" name="jam_ke" class="form-control" placeholder="Contoh: 1" required>
                            <div class="form-text text-xs">Isi '0' untuk Upacara/Doa Pagi.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Keterangan</label>
                            <select name="keterangan" class="form-select">
                                <option value="KBM">KBM (Pelajaran)</option>
                                <option value="ISTIRAHAT">Istirahat</option>
                                <option value="UPACARA">Upacara / Literasi</option>
                                <option value="PULANG">Kepulangan</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-12"><label class="form-label small fw-bold text-primary">Senin - Kamis / Sabtu</label></div>
                            <div class="col-6 mb-3">
                                <input type="time" name="mulai" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-6 mb-3">
                                <input type="time" name="selesai" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-12"><label class="form-label small fw-bold text-success">Khusus Jumat (Opsional)</label></div>
                            <div class="col-6 mb-3">
                                <input type="time" name="mulai_jumat" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 mb-3">
                                <input type="time" name="selesai_jumat" class="form-control form-control-sm">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold">SIMPAN DATA</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-clock-history me-2 text-primary"></i> Daftar Jam ({{ $currentCategory->nama_jadwal }})
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-4">Ke</th>
                                    <th>Keterangan</th>
                                    <th>Senin-Kamis</th>
                                    <th>Jumat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jam as $j)
                                <tr class="{{ $j->keterangan != 'KBM' ? 'table-warning' : '' }}">
                                    <td class="ps-4 fw-bold">{{ $j->jam_ke }}</td>
                                    <td>
                                        @if($j->keterangan == 'KBM')
                                            <span class="badge bg-primary">KBM</span>
                                        @elseif($j->keterangan == 'ISTIRAHAT')
                                            <span class="badge bg-warning text-dark">ISTIRAHAT</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $j->keterangan }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="bi bi-clock me-1 text-muted"></i> 
                                        {{ substr($j->mulai, 0, 5) }} - {{ substr($j->selesai, 0, 5) }}
                                    </td>
                                    <td>
                                        @if($j->mulai_jumat)
                                            <span class="text-success fw-bold">
                                                {{ substr($j->mulai_jumat, 0, 5) }} - {{ substr($j->selesai_jumat, 0, 5) }}
                                            </span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.jam_kbm.delete', $j->id) }}" class="btn btn-sm btn-outline-danger btn-delete">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @if($jam->isEmpty())
                                <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada setting jam di jadwal ini.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddCategory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Buat Jenis Jadwal Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.jam_kbm.category.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label class="form-label fw-bold">Nama Jadwal</label>
                        <input type="text" name="nama_jadwal" class="form-control" placeholder="Contoh: Jadwal Ramadhan / Jadwal Ujian" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary fw-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection