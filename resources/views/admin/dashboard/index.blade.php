@extends('layouts.admin_master')

@section('title')
    Dashboard Utama
@endsection

@section('content')

<style>
    .hover-card {
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        border-color: #0d6efd !important; /* Memberi border biru halus saat hover */
    }
</style>

<div class="container-fluid">

    <div class="row g-3 mb-4">
        
        {{-- ============================================= --}}
        {{-- STATISTIK MODE TERPADU (YAYASAN) --}}
        {{-- Fokus: Aset, Populasi Siswa, SDM --}}
        {{-- ============================================= --}}
        @if($mode == 'TERPADU')
            
            {{-- KARTU 1: TOTAL UNIT --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded me-3 text-primary">
                            <i class="bi bi-diagram-3 fs-3"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase">Total Unit</div>
                            <div class="fs-4 fw-bold text-dark">{{ $stats['total_unit'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KARTU 2: TOTAL SISWA (PENGGANTI MAPEL) --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded me-3 text-success">
                            <i class="bi bi-people-fill fs-3"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase">Total Siswa</div>
                            <div class="fs-4 fw-bold text-dark">{{ $stats['total_siswa'] ?? 0 }}</div> 
                        </div>
                    </div>
                </div>
            </div>

            {{-- KARTU 3: TOTAL SDM / GURU (PENGGANTI ROMBEL) --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded me-3 text-warning">
                            <i class="bi bi-person-badge fs-3"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase">Total SDM</div>
                            <div class="fs-4 fw-bold text-dark">{{ $stats['total_sdm'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KARTU 4: TOTAL ASET/KELAS --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-3 rounded me-3 text-info">
                            <i class="bi bi-building fs-3"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase">Ruang Kelas</div>
                            <div class="fs-4 fw-bold text-dark">{{ $stats['total_kelas'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

        {{-- ============================================= --}}
        {{-- STATISTIK MODE TUNGGAL (ADMIN SEKOLAH) --}}
        {{-- Fokus: Akademik, Mapel, Jurusan --}}
        {{-- ============================================= --}}
        @else
            
            {{-- Mapel Aktif --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded me-3 text-success">
                            <i class="bi bi-book fs-3"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase">Mapel Aktif</div>
                            <div class="fs-4 fw-bold text-dark">{{ $stats['total_mapel'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rombel / Kelas --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded me-3 text-warning">
                            <i class="bi bi-door-open fs-3"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase">Rombel / Kelas</div>
                            <div class="fs-4 fw-bold text-dark">{{ $stats['total_kelas'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Jurusan --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-3 rounded me-3 text-info">
                            <i class="bi bi-tools fs-3"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase">Jurusan</div>
                            <div class="fs-4 fw-bold text-dark">{{ $stats['total_jurusan'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

             {{-- Guru (Opsional) --}}
             <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded me-3 text-primary">
                            <i class="bi bi-person-workspace fs-3"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase">Guru & Staff</div>
                            <div class="fs-4 fw-bold text-dark">{{ $stats['total_sdm'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
    </div>

    <div class="mb-2 fw-bold text-secondary text-uppercase small ls-1">Akses Cepat</div>
    
    <div class="row g-4">
                        
        @if($mode == 'TUNGGAL')
            {{-- TAMPILAN MODE TUNGGAL (Admin Sekolah) - OPERASIONAL --}}
            
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.sekolah.identitas') }}" class="card text-decoration-none h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center py-4 d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-3 text-secondary"><i class="bi bi-building fs-1"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Identitas</h6>
                        <small class="text-muted">Profil Sekolah</small>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('admin.mapel.index') }}" class="card text-decoration-none h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center py-4 d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-3 text-primary"><i class="bi bi-collection fs-1"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Mata Pelajaran</h6>
                        <small class="text-muted">Atur Kurikulum</small>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('admin.kelas.index') }}" class="card text-decoration-none h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center py-4 d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-3 text-success"><i class="bi bi-people fs-1"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Data Kelas</h6>
                        <small class="text-muted">Manajemen Rombel</small>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('admin.jam_kbm.index') }}" class="card text-decoration-none h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center py-4 d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-3 text-warning"><i class="bi bi-clock fs-1"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Jam KBM</h6>
                        <small class="text-muted">Jadwal Pelajaran</small>
                    </div>
                </a>
            </div>

        @else
            {{-- TAMPILAN MODE TERPADU (Yayasan) - STRATEGIS & PENGAWASAN --}}
            
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.sekolah.identitas') }}" class="card text-decoration-none h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center py-4 d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-3 text-primary"><i class="bi bi-buildings fs-1"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Profil Yayasan</h6>
                        <small class="text-muted">Data Induk Pusat</small>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('admin.sekolah.unit.index') }}" class="card text-decoration-none h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center py-4 d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-3 text-success"><i class="bi bi-diagram-3 fs-1"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Unit Sekolah</h6>
                        <small class="text-muted">Kelola Cabang</small>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="#" class="card text-decoration-none h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center py-4 d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-3 text-danger"><i class="bi bi-wallet2 fs-1"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Keuangan</h6>
                        <small class="text-muted">Monitoring SPP & Kas</small>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="#" class="card text-decoration-none h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center py-4 d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-3" style="color: #6f42c1;"><i class="bi bi-person-lines-fill fs-1"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Kepegawaian</h6>
                        <small class="text-muted">Data Guru & Staff</small>
                    </div>
                </a>
            </div>

        @endif
        
    </div>

</div>
@endsection