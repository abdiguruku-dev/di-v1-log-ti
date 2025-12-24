<div id="sidebar-wrapper">
    <div class="sidebar-header">
        <img src="{{ $logoApp }}" onerror="this.src='https://ui-avatars.com/api/?name=SP&background=random'" alt="Logo" class="logo-img">
        <div class="brand-text">
            <h5 title="{{ $namaSekolah }}">{{ $namaSekolah }}</h5>
            <small>{{ Str::limit($namaAplikasi, 25) }}</small>
        </div>
    </div>

    <nav class="pb-5 accordion" id="sidebarAccordion">

        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} mt-3">
            <i class="bi bi-grid-fill"></i> <span>Dashboard</span>
        </a>

        @if($mode == 'TERPADU')
        <div class="menu-label">MANAJEMEN YAYASAN</div>

        <a href="{{ route('admin.sekolah.identitas') }}" class="nav-link {{ request()->routeIs('admin.sekolah.identitas') ? 'active' : '' }}">
            <i class="bi bi-buildings"></i> <span>Profil Yayasan</span>
        </a>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterUnit" role="button" aria-expanded="false">
            <i class="bi bi-diagram-3"></i> <span>Unit Sekolah</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse {{ request()->routeIs('admin.sekolah.unit.*') ? 'show' : '' }}" id="masterUnit" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="{{ route('admin.sekolah.unit.index') }}" class="nav-link {{ request()->routeIs('admin.sekolah.unit.*') ? 'active' : '' }}"><i class="bi bi-circle-fill"></i> <span>Data Semua Unit</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Kepala Sekolah</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Konfigurasi Unit</span></a></li>
            </ul>
        </div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterGlobal" role="button" aria-expanded="false">
            <i class="bi bi-globe"></i> <span>Master Global</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse" id="masterGlobal" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Tahun Ajaran (Global)</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Mata Pelajaran (Bank)</span></a></li>
            </ul>
        </div>

        <div class="menu-label">LAPORAN & MONITORING</div>
        <a href="#" class="nav-link"><i class="bi bi-bar-chart-line"></i> <span>Laporan Gabungan</span></a>
        <a href="#" class="nav-link"><i class="bi bi-people"></i> <span>Monitoring SDM</span></a>
        <a href="#" class="nav-link"><i class="bi bi-cash-stack"></i> <span>Monitoring Keuangan</span></a>

        @else

        <div class="menu-label">DATA MASTER</div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterSekolah" role="button" aria-expanded="false">
            <i class="bi bi-building"></i> <span>Master Sekolah</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse {{ request()->routeIs('admin.sekolah.*') || request()->routeIs('admin.tahun_ajaran.*') ? 'show' : '' }}" id="masterSekolah" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="{{ route('admin.sekolah.identitas') }}" class="nav-link {{ request()->routeIs('admin.sekolah.identitas') ? 'active' : '' }}"><i class="bi bi-circle-fill"></i> <span>Identitas Sekolah</span></a></li>
                <li><a href="{{ route('admin.tahun_ajaran.index') }}" class="nav-link {{ request()->routeIs('admin.tahun_ajaran.index') ? 'active' : '' }}"><i class="bi bi-circle-fill"></i> <span>Tahun Ajaran</span></a></li>
            </ul>
        </div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterUmum" role="button" aria-expanded="false">
            <i class="bi bi-globe"></i> <span>Master Umum</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse" id="masterUmum" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Agama</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Pekerjaan</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Pendidikan</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Hubungan Keluarga</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Transportasi & Tinggal</span></a></li>
            </ul>
        </div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterAkademik" role="button" aria-expanded="false">
            <i class="bi bi-book"></i> <span>Master Akademik</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse {{ request()->routeIs('admin.kurikulum.*') || request()->routeIs('admin.kalender.*') || request()->routeIs('admin.penilaian.*') || request()->routeIs('admin.kkm.*') || request()->routeIs('admin.jurusan.*') || request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapel.*') || request()->routeIs('admin.jam_kbm.*') ? 'show' : '' }}" id="masterAkademik" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="{{ route('admin.kurikulum.index') }}" class="nav-link {{ request()->routeIs('admin.kurikulum.index') ? 'active' : '' }}"><i class="bi bi-circle-fill"></i> <span>Kurikulum</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Kalender Akademik</span></a></li>

                <li><a href="#" class="nav-link {{ request()->routeIs('admin.penilaian.*') ? 'active' : '' }}"><i class="bi bi-circle-fill"></i> <span>Jenis Penilaian</span></a></li>
                <li><a href="#" class="nav-link {{ request()->routeIs('admin.kkm.*') ? 'active' : '' }}"><i class="bi bi-circle-fill"></i> <span>Atur KKM / Kriteria</span></a></li>

                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Master Projek (P5)</span></a></li>
                <li><a href="{{ route('admin.jurusan.index') }}" class="nav-link {{ request()->routeIs('admin.jurusan.*') ? 'active' : '' }}"><i class="bi bi-circle-fill"></i> <span>Jurusan / Kompetensi</span></a></li>
                <li><a href="{{ route('admin.kelas.index') }}" class="nav-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}"><i class="bi bi-circle-fill"></i> <span>Data Kelas</span></a></li>
                <li><a href="{{ route('admin.mapel.index') }}" class="nav-link {{ request()->routeIs('admin.mapel.*') ? 'active' : '' }}"><i class="bi bi-circle-fill"></i> <span>Mata Pelajaran</span></a></li>
                <li><a href="{{ route('admin.jam_kbm.index') }}" class="nav-link {{ request()->routeIs('admin.jam_kbm.*') ? 'active' : '' }}"><i class="bi bi-circle-fill"></i> <span>Jam KBM</span></a></li>
            </ul>
        </div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterPMB" role="button" aria-expanded="false">
            <i class="bi bi-door-open-fill"></i> <span>Master PMB</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse" id="masterPMB" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Tahun Angkatan</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Gelombang & Biaya</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Jalur Pendaftaran</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Syarat Dokumen</span></a></li>
            </ul>
        </div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterKesiswaan" role="button" aria-expanded="false">
            <i class="bi bi-person-lines-fill"></i> <span>Master Kesiswaan</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse" id="masterKesiswaan" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Data Ekstrakurikuler</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Jenis Prestasi</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Poin Pelanggaran</span></a></li>
            </ul>
        </div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterBK" role="button" aria-expanded="false">
            <i class="bi bi-heart-pulse-fill"></i> <span>Master BK</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse" id="masterBK" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Jenis Layanan</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Bidang Bimbingan</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Tindak Lanjut</span></a></li>
            </ul>
        </div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterKepegawaian" role="button" aria-expanded="false">
            <i class="bi bi-person-badge-fill"></i> <span>Master Kepegawaian</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse" id="masterKepegawaian" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Jabatan / Tugas</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Status Kepegawaian</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Golongan / Pangkat</span></a></li>
            </ul>
        </div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterPresensi" role="button" aria-expanded="false">
            <i class="bi bi-fingerprint"></i> <span>Master Presensi</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse" id="masterPresensi" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Jam Kerja (Shift)</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Lokasi (Koordinat)</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Jenis Cuti / Izin</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Mesin Fingerprint</span></a></li>
            </ul>
        </div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterKeuangan" role="button" aria-expanded="false">
            <i class="bi bi-wallet2"></i> <span>Master Keuangan</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse" id="masterKeuangan" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Pos Pembayaran</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Jenis Potongan</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Akun Bank</span></a></li>
            </ul>
        </div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterSarana" role="button" aria-expanded="false">
            <i class="bi bi-box-seam"></i> <span>Master Sarpras</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse" id="masterSarana" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Lokasi / Ruangan</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Kategori Barang</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Kondisi Barang</span></a></li>
            </ul>
        </div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterPustaka" role="button" aria-expanded="false">
            <i class="bi bi-book-half"></i> <span>Master Perpustakaan</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse" id="masterPustaka" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Kategori Buku</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Rak Buku</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Satuan Denda</span></a></li>
            </ul>
        </div>

        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterSurat" role="button" aria-expanded="false">
            <i class="bi bi-envelope-paper"></i> <span>Master Persuratan</span><i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="collapse" id="masterSurat" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Kode Klasifikasi</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Sifat Surat</span></a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-circle-fill"></i> <span>Template Surat</span></a></li>
            </ul>
        </div>

        <div class="menu-label">MODUL UTAMA</div>
        <a href="#" class="nav-link"><i class="bi bi-door-open"></i> <span>PMB Online</span></a>
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#menuKesiswaan" role="button" aria-expanded="false">
            <i class="bi bi-person-lines-fill"></i>
            <span>Kesiswaan</span>
            <i class="bi bi-chevron-down arrow"></i>
        </a>

        <div class="collapse {{ request()->routeIs('admin.murid.*') ? 'show' : '' }}" id="menuKesiswaan" data-bs-parent="#sidebarAccordion">
            <ul class="submenu">

                <li class="submenu-label">
                    DATA INDUK
                </li>

                <li>
                    <a href="{{ route('admin.murid.index') }}" class="nav-link {{ request()->routeIs('admin.murid.index') ? 'active' : '' }}">
                        <i class="bi bi-circle-fill"></i> <span>Data Murid Aktif</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link btn-not-ready" data-pesan="Fitur Data Orang Tua/Wali akan dikerjakan nanti.">
                        <i class="bi bi-circle-fill"></i> <span>Data Orang Tua/Wali</span>
                    </a>
                </li>

                <li class="submenu-label">
                    MUTASI & STATUS
                </li>

                <li>
                    <a href="#" class="nav-link btn-not-ready" data-pesan="Fitur Mutasi Masuk sedang dikerjakan.">
                        <i class="bi bi-circle-fill"></i> <span>Mutasi Masuk</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="nav-link btn-not-ready" data-pesan="Fitur Mutasi Keluar sedang dikerjakan.">
                        <i class="bi bi-circle-fill"></i> <span>Mutasi Keluar</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link btn-not-ready" data-pesan="Fitur Data Status Non-Aktif sedang dikerjakan.">
                        <i class="bi bi-circle-fill"></i> <span>Status Non-Aktif</span>
                    </a>
                </li>

                <li class="submenu-label">
                    MANAJEMEN KELAS
                </li>

                <li>
                    <a href="#" class="nav-link btn-not-ready" data-pesan="Fitur Plotting Kelas sedang dikerjakan.">
                        <i class="bi bi-circle-fill"></i> <span>Plotting Kelas</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link btn-not-ready" data-pesan="Fitur Kenaikan Kelas sedang dikerjakan.">
                        <i class="bi bi-circle-fill"></i> <span>Kenaikan Kelas</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link btn-not-ready" data-pesan="Fitur Kelulusan sedang dikerjakan.">
                        <i class="bi bi-circle-fill"></i> <span>Proses Kelulusan</span>
                    </a>
                </li>

                <li class="submenu-label">
                    LAINNYA
                </li>

                <li>
                    <a href="#" class="nav-link btn-not-ready" data-pesan="Fitur Catatan Pelanggaran & Prestasi sedang dikerjakan.">
                        <i class="bi bi-circle-fill"></i> <span>Prestasi & Karakter</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link btn-not-ready" data-pesan="Fitur Data Alumni sedang dikerjakan.">
                        <i class="bi bi-circle-fill"></i> <span>Data Alumni</span>
                    </a>
                </li>

            </ul>
        </div>

        <a href="#" class="nav-link"><i class="bi bi-heart-pulse"></i> <span>Bimbingan Konseling</span></a>
        <a href="#" class="nav-link"><i class="bi bi-journal-check"></i> <span>Pembelajaran (LMS)</span></a>
        <a href="#" class="nav-link"><i class="bi bi-person-workspace"></i> <span>Kepegawaian</span></a>
        <a href="#" class="nav-link"><i class="bi bi-fingerprint"></i> <span>Presensi</span></a>
        <a href="#" class="nav-link"><i class="bi bi-cash-stack"></i> <span>Keuangan</span></a>
        <a href="#" class="nav-link"><i class="bi bi-book-half"></i> <span>Perpustakaan</span></a>
        <a href="#" class="nav-link"><i class="bi bi-tools"></i> <span>Aset & Sarpras</span></a>
        <a href="#" class="nav-link"><i class="bi bi-envelope"></i> <span>Persuratan (TU)</span></a>

        @endif

        <div class="menu-label">SYSTEM</div>
        <a href="#" class="nav-link"><i class="bi bi-shield-lock"></i> <span>Users & Roles</span></a>
        <a href="#" class="nav-link"><i class="bi bi-gear"></i> <span>Settings</span></a>
    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-2 btn-logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>

</div>