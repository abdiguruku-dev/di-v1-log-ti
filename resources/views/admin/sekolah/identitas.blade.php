@extends('layouts.admin_master')
@section('page_title', 'Identitas Instansi')

@section('content')
<div class="container-fluid">
    
    <div class="card border-0 shadow-sm mb-4 bg-dark text-white">
        <div class="card-body d-flex justify-content-between align-items-center py-2">
            <div>
                <span class="badge bg-warning text-dark me-2">MODE APLIKASI</span>
                <strong class="text-uppercase">{{ $mode }}</strong>
                <span class="text-white-50 ms-2 small">
                    {{ $mode == 'TUNGGAL' ? '(Sekolah Satuan/Mandiri)' : '(Yayasan / Sekolah Terpadu)' }}
                </span>
            </div>
            <form action="{{ route('admin.sekolah.switch_mode') }}" method="POST">
                @csrf
                @if($mode == 'TUNGGAL')
                    <input type="hidden" name="mode" value="TERPADU">
                    <button type="submit" class="btn btn-outline-warning btn-sm btn-switch">
                        <i class="bi bi-toggle-off me-1"></i> Ubah ke Mode Terpadu
                    </button>
                @else
                    <input type="hidden" name="mode" value="TUNGGAL">
                    <button type="submit" class="btn btn-outline-light btn-sm btn-switch">
                        <i class="bi bi-toggle-on me-1"></i> Kembali ke Mode Tunggal
                    </button>
                @endif
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm"><i class="bi bi-check-circle me-2"></i> {{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.sekolah.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $sekolah->id }}">
          
        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 fw-bold">
                        @if($sekolah->mode_aplikasi == 'TUNGGAL')
                            <i class="bi bi-building me-2 text-primary"></i> IDENTITAS SEKOLAH INDUK
                        @else
                            <i class="bi bi-buildings me-2 text-success"></i> IDENTITAS YAYASAN / PUSAT
                        @endif
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-4 bg-light p-3 rounded border">
                            <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-info-circle me-2"></i> INFORMASI UTAMA</h6>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">
                                @if($sekolah->mode_aplikasi == 'TUNGGAL') Nama Sekolah Resmi @else Nama Yayasan / Pusat @endif
                            </label>
                            <input type="text" name="nama_sekolah" class="form-control form-control-lg fw-bold" 
                                   value="{{ $sekolah->nama_sekolah }}" required>
                        </div>

                        @if($sekolah->mode_aplikasi == 'TUNGGAL')
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">NPSN</label>
                                    <input type="text" name="npsn" class="form-control" value="{{ $sekolah->npsn ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">NSS / NSM</label>
                                    <input type="text" name="nss" class="form-control" value="{{ $sekolah->nss ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Akreditasi</label>
                                    <select name="akreditasi" class="form-select">
                                        <option value="">- Pilih -</option>
                                        <option value="A" {{ ($sekolah->akreditasi ?? '') == 'A' ? 'selected' : '' }}>A (Unggul)</option>
                                        <option value="B" {{ ($sekolah->akreditasi ?? '') == 'B' ? 'selected' : '' }}>B (Baik)</option>
                                        <option value="C" {{ ($sekolah->akreditasi ?? '') == 'C' ? 'selected' : '' }}>C (Cukup)</option>
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Nama Ketua Yayasan</label>
                                    <input type="text" name="kepala_sekolah" class="form-control" value="{{ $sekolah->kepala_sekolah ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">No. SK Kemenkumham</label>
                                    <input type="text" name="nss" class="form-control" value="{{ $sekolah->nss ?? '' }}">
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label small text-muted">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ $sekolah->alamat ?? '' }}</textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Email Resmi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" value="{{ $sekolah->email ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">No. WhatsApp (Format: 628xxx)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" name="telepon" class="form-control" value="{{ $sekolah->telepon ?? '' }}" placeholder="Contoh: 62812345678">
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label class="form-label small text-muted">Website</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <input type="text" name="website" class="form-control" value="{{ $sekolah->website ?? '' }}" placeholder="www.sekolah.sch.id">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 mt-4 bg-light p-3 rounded border">
                            <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-share me-2"></i> MEDIA SOSIAL</h6>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-muted">Facebook</label>
                                <div class="input-group">
                                    <span class="input-group-text text-primary"><i class="bi bi-facebook"></i></span>
                                    <input type="text" name="facebook" class="form-control" value="{{ $sekolah->facebook ?? '' }}" placeholder="Link / Nama Akun">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-muted">Instagram</label>
                                <div class="input-group">
                                    <span class="input-group-text text-danger"><i class="bi bi-instagram"></i></span>
                                    <input type="text" name="instagram" class="form-control" value="{{ $sekolah->instagram ?? '' }}" placeholder="@username">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-muted">YouTube</label>
                                <div class="input-group">
                                    <span class="input-group-text text-danger"><i class="bi bi-youtube"></i></span>
                                    <input type="text" name="youtube" class="form-control" value="{{ $sekolah->youtube ?? '' }}" placeholder="Link Channel">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-muted">TikTok</label>
                                <div class="input-group">
                                    <span class="input-group-text text-dark"><i class="bi bi-tiktok"></i></span>
                                    <input type="text" name="tiktok" class="form-control" value="{{ $sekolah->tiktok ?? '' }}" placeholder="@username">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px; z-index: 100;">
                    <div class="card-header bg-white fw-bold py-3">Logo & Pengaturan</div>
                    <div class="card-body text-center">
                        
                        @if(!empty($sekolah->logo))
                            <div class="mb-3 p-2 border rounded bg-light">
                                <img src="{{ asset('uploads/'.$sekolah->logo) }}" class="img-fluid" style="max-height: 150px">
                            </div>
                        @else
                            <div class="mb-3 text-muted p-4 border border-dashed rounded bg-light">
                                <i class="bi bi-image fs-1 d-block mb-2"></i>
                                <small>Belum ada logo</small>
                            </div>
                        @endif
                        
                        <div class="mb-3 text-start">
                            <label class="form-label small fw-bold text-muted">Upload Logo Baru</label>
                            <input type="file" name="logo" class="form-control mb-3" accept="image/*">
                            <div class="form-text text-xs">Format: JPG, PNG (Max 2MB).</div>
                        </div>
                        
                        @if($mode == 'TUNGGAL')
                            <div class="mb-4 text-start">
                                <label class="form-label small fw-bold text-muted">Jenjang Sekolah</label>
                                <select name="jenjang" class="form-select">
                                    <option value="SD" {{ ($sekolah->jenjang ?? '') == 'SD' ? 'selected' : '' }}>SD / MI</option>
                                    <option value="SMP" {{ ($sekolah->jenjang ?? '') == 'SMP' ? 'selected' : '' }}>SMP / MTs</option>
                                    <option value="SMA" {{ ($sekolah->jenjang ?? '') == 'SMA' ? 'selected' : '' }}>SMA / MA</option>
                                    <option value="SMK" {{ ($sekolah->jenjang ?? '') == 'SMK' ? 'selected' : '' }}>SMK (3 Tahun)</option>
                                    <option value="SMK 4 Tahun" {{ ($sekolah->jenjang ?? '') == 'SMK 4 Tahun' ? 'selected' : '' }}>SMK (4 Tahun)</option>
                                </select>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                            <i class="bi bi-save me-2"></i> SIMPAN PROFIL UTAMA
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form> 


    @if($mode == 'TERPADU')
        <hr class="my-5 border-secondary">
        
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-primary m-0"><i class="bi bi-diagram-3 me-2"></i> Unit Sekolah (Cabang)</h5>
                    <button class="btn btn-sm btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahUnit">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Unit Baru
                    </button>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-secondary small text-uppercase">
                                    <tr>
                                        <th class="ps-4">Jenjang</th>
                                        <th width="10%">Logo</th> <th>Nama Unit & Domain</th>
                                        <th>Kepala Sekolah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($units as $u)
                                    <tr>
                                        <td class="ps-4"><span class="badge bg-info text-dark rounded-pill">{{ $u->jenjang }}</span></td>
                                        
                                        <td>
                                            @if($u->logo)
                                                <img src="{{ asset('uploads/'.$u->logo) }}" class="rounded border" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted border" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="fw-bold text-dark">{{ $u->nama_unit }}</span><br>
                                            @if($u->custom_domain)
                                                <small class="text-primary"><i class="bi bi-globe2 me-1"></i>{{ $u->custom_domain }}</small>
                                            @else
                                                <small class="text-muted fst-italic">- Ikut Domain Yayasan -</small>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $u->kepala_sekolah }}<br>
                                            <small class="text-muted">NIP: {{ $u->nip_kepala_sekolah ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEditUnit{{ $u->id }}" title="Edit Data">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="{{ route('admin.sekolah.unit.delete', $u->id) }}" class="btn btn-sm btn-outline-danger btn-delete"  title="Hapus Permanen">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if($units->isEmpty())
                                    <tr><td colspan="5" class="text-center py-5 text-muted fst-italic">Belum ada unit sekolah. Silakan klik tombol "Tambah Unit Baru".</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

@if($mode == 'TERPADU')
    
    <div class="modal fade" id="modalTambahUnit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Tambah Unit Sekolah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.sekolah.unit.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold small">Jenjang</label>
                                <select name="jenjang" class="form-select" required>
                                    <option value="SD">SD / MI</option>
                                    <option value="SMP">SMP / MTs</option>
                                    <option value="SMA">SMA / MA</option>
                                    <option value="SMK">SMK (3 Tahun)</option>
                                    <option value="SMK 4 Tahun">SMK (4 Tahun)</option> </select>
                            </div>
                            <div class="col-md-9 mb-3">
                                <label class="form-label fw-bold small">Nama Sekolah (Unit)</label>
                                <input type="text" name="nama_unit" class="form-control" placeholder="Contoh: SMK TAMAN KARYA" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Alamat Lengkap Unit</label>
                            <textarea name="alamat_unit" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Kepala Sekolah Unit</label>
                                <input type="text" name="kepala_sekolah" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">NIP / NIY</label>
                                <input type="text" name="nip_kepala_sekolah" class="form-control">
                            </div>
                        </div>
                        
                         <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">Email Unit</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">No. Telp / HP</label>
                                <input type="text" name="no_telp" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">Website</label>
                                <input type="text" name="website" class="form-control" placeholder="http://...">
                            </div>
                        </div>

                        <div class="mb-3 p-2 bg-light border rounded">
                            <label class="form-label fw-bold small text-primary">Custom Domain</label>
                            <input type="text" name="custom_domain" class="form-control" placeholder="Contoh: smktamankarya.sch.id">
                            <small class="text-muted d-block mt-1" style="font-size: 11px;">Kosongkan jika ikut domain yayasan.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Logo Unit</label>
                            <input type="file" name="logo_unit" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-2"></i> SIMPAN UNIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($units as $u)
    <div class="modal fade" id="modalEditUnit{{ $u->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-bold text-dark">Edit Unit: {{ $u->nama_unit }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <form action="{{ route('admin.sekolah.unit.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <input type="hidden" name="id" value="{{ $u->id }}"> 
                    
                    <div class="modal-body text-start">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold small">Jenjang</label>
                                <select name="jenjang" class="form-select" required>
                                    <option value="SD" {{ $u->jenjang == 'SD' ? 'selected' : '' }}>SD / MI</option>
                                    <option value="SMP" {{ $u->jenjang == 'SMP' ? 'selected' : '' }}>SMP / MTs</option>
                                    <option value="SMA" {{ $u->jenjang == 'SMA' ? 'selected' : '' }}>SMA / MA</option>
                                    <option value="SMK" {{ $u->jenjang == 'SMK' ? 'selected' : '' }}>SMK (3 Tahun)</option>
                                    <option value="SMK 4 Tahun" {{ $u->jenjang == 'SMK 4 Tahun' ? 'selected' : '' }}>SMK (4 Tahun)</option> </select>
                            </div>
                            <div class="col-md-9 mb-3">
                                <label class="form-label fw-bold small">Nama Sekolah (Unit)</label>
                                <input type="text" name="nama_unit" class="form-control" value="{{ $u->nama_unit }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Alamat Lengkap Unit</label>
                            <textarea name="alamat_unit" class="form-control" rows="2">{{ $u->alamat_unit }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Kepala Sekolah Unit</label>
                                <input type="text" name="kepala_sekolah" class="form-control" value="{{ $u->kepala_sekolah }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">NIP / NIY</label>
                                <input type="text" name="nip_kepala_sekolah" class="form-control" value="{{ $u->nip_kepala_sekolah }}">
                            </div>
                        </div>
                        
                         <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">Email Unit</label>
                                <input type="email" name="email" class="form-control" value="{{ $u->email }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">No. Telp / HP</label>
                                <input type="text" name="no_telp" class="form-control" value="{{ $u->no_telp }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">Website</label>
                                <input type="text" name="website" class="form-control" value="{{ $u->website }}">
                            </div>
                        </div>
                        
                         <div class="mb-3 p-2 bg-light border rounded">
                            <label class="form-label fw-bold small text-primary">Custom Domain</label>
                            <input type="text" name="custom_domain" class="form-control" value="{{ $u->custom_domain }}">
                            <small class="text-muted d-block mt-1" style="font-size: 11px;">Format: domain.sch.id</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Ganti Logo Unit</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                @if($u->logo)
                                    <div class="border p-1 rounded bg-white">
                                        <img src="{{ asset('uploads/'.$u->logo) }}" alt="Logo Saat Ini" style="height: 60px; width: auto;">
                                    </div>
                                    <div class="small text-success"><i class="bi bi-check-circle-fill"></i> Logo Tersimpan</div>
                                @else
                                    <div class="small text-muted fst-italic">Belum ada logo tersimpan.</div>
                                @endif
                            </div>
                            <input type="file" name="logo_unit" class="form-control">
                            <div class="form-text text-xs">Biarkan kosong jika tidak ingin mengganti logo.</div>
                        </div>
                        </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-save me-2"></i> UPDATE PERUBAHAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endif

@endsection