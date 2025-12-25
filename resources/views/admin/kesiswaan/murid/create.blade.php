@extends('layouts.admin_master')
@section('page_title', 'Input Data Murid Baru')

@section('content')
<div class="container-fluid mb-5">
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-user-plus me-2"></i>Formulir Peserta Didik (Wizard)
            </h6>
        </div>
        
        <div class="card-body">
            {{-- ERROR CHECK --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Gagal Menyimpan!</strong> Periksa inputan Anda.
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.murid.store') }}" method="POST" enctype="multipart/form-data" id="formMuridWizard" novalidate>
            @csrf
            <input type="hidden" name="id" id="murid_id_hidden" value="">

            {{-- INDIKATOR STEP --}}
            <ul class="nav wizard-tabs">
                <li class="nav-item"><a class="nav-link active" href="#" data-step="1">1</a><span class="wizard-step-label">Pendaftaran</span></li>
                <li class="nav-item"><a class="nav-link" href="#" data-step="2">2</a><span class="wizard-step-label">Data Murid</span></li>
                <li class="nav-item"><a class="nav-link" href="#" data-step="3">3</a><span class="wizard-step-label">Keluarga</span></li>
                <li class="nav-item"><a class="nav-link" href="#" data-step="4">4</a><span class="wizard-step-label">Alamat</span></li>
                <li class="nav-item"><a class="nav-link" href="#" data-step="5">5</a><span class="wizard-step-label">Pendidikan</span></li>
                <li class="nav-item"><a class="nav-link" href="#" data-step="6">6</a><span class="wizard-step-label">Orang Tua</span></li>
                <li class="nav-item"><a class="nav-link" href="#" data-step="7">7</a><span class="wizard-step-label">Kesehatan</span></li>
                <li class="nav-item"><a class="nav-link" href="#" data-step="8">8</a><span class="wizard-step-label">Dokumen</span></li>
            </ul>

            <div class="tab-content" id="wizardContent">

                {{-- === STEP 1: JENIS PENDAFTARAN === --}}
                <div class="tab-pane fade show active">
                    <h5 class="text-primary font-weight-bold mb-4">Langkah 1: Jalur Pendaftaran</h5>
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <label class="d-block mb-3 fw-bold text-center">Status Masuk Murid:</label>
                            <div class="row g-3 custom-radio-group">
                                <div class="col-md-4">
                                    <input type="radio" name="jenis_pendaftaran" id="jp1" value="Siswa Baru" required checked>
                                    <label for="jp1"><i class="fas fa-user-graduate fa-2x mb-2 d-block"></i>Murid Baru</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" name="jenis_pendaftaran" id="jp2" value="Pindahan">
                                    <label for="jp2"><i class="fas fa-exchange-alt fa-2x mb-2 d-block"></i>Pindahan</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" name="jenis_pendaftaran" id="jp3" value="Kembali Bersekolah">
                                    <label for="jp3"><i class="fas fa-undo fa-2x mb-2 d-block"></i>Kembali Sekolah</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary btn-exit-wizard shadow-sm"><i class="fas fa-times me-2"></i> Batal & Kembali</a>
                        <button type="button" class="btn btn-primary px-4 btn-next" onclick="nextStep()">Lanjut & Simpan Draft <i class="fas fa-arrow-right ms-2"></i></button>
                    </div>
                </div> 
                {{-- Penutup Step 1 --}}

                {{-- === STEP 2: DATA PRIBADI === --}}
                <div class="tab-pane fade">
                    <h5 class="text-primary font-weight-bold mb-4">Langkah 2: Data Pribadi</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">NIS <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="nis" id="nis" class="form-control" required>
                                <div class="input-group-text bg-light"><input class="form-check-input mt-0 me-1" type="checkbox" id="nis_auto"><label class="form-check-label small">Otomatis</label></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3"><label class="fw-bold">NISN</label><input type="text" name="nisn" class="form-control"></div>
                        <div class="col-md-12 mb-3"><label class="fw-bold">Nama Lengkap <span class="text-danger">*</span></label><input type="text" name="nama_lengkap" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Nama Panggilan</label><input type="text" name="nama_panggilan" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>NIK</label><input type="number" name="nik" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label class="fw-bold">Jenis Kelamin <span class="text-danger">*</span></label><select name="jenis_kelamin" class="form-select" required><option value="">- Pilih -</option><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
                        <div class="col-md-6 mb-3"><label>Agama</label><select name="agama" class="form-select"><option value="Islam">Islam</option><option value="Kristen">Kristen</option><option value="Katolik">Katolik</option><option value="Hindu">Hindu</option><option value="Buddha">Buddha</option></select></div>
                        <div class="col-md-6 mb-3"><label>Kewarganegaraan</label><select name="kewarganegaraan" class="form-select"><option value="WNI">WNI</option><option value="WNA">WNA</option></select></div>
                    </div>
                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary btn-exit-wizard shadow-sm"><i class="fas fa-times me-2"></i> Batal</a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary px-4" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</button>
                            <button type="button" class="btn btn-primary px-4 btn-next" onclick="nextStep()">Lanjut & Simpan Draft <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div> 
                {{-- Penutup Step 2 --}}

                {{-- === STEP 3: KELUARGA === --}}
                <div class="tab-pane fade">
                    <h5 class="text-primary font-weight-bold mb-4">Langkah 3: Keluarga</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3"><label>Anak ke-</label><input type="number" name="anak_ke" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label>Jml Sdr Kandung</label><input type="number" name="jml_saudara_kandung" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label>Jml Sdr Tiri</label><input type="number" name="jml_saudara_tiri" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Status Keluarga</label><select name="status_keluarga" class="form-select"><option value="Anak Kandung">Anak Kandung</option><option value="Anak Tiri">Anak Tiri</option></select></div>
                        <div class="col-md-6 mb-3"><label>Status Anak</label><select name="status_anak" class="form-select"><option value="Lengkap">Lengkap</option><option value="Yatim">Yatim</option><option value="Piatu">Piatu</option></select></div>
                        <div class="col-md-12 mb-3"><label>Bahasa Sehari-hari</label><input type="text" name="bahasa_sehari_hari" class="form-control"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary btn-exit-wizard shadow-sm"><i class="fas fa-times me-2"></i> Batal</a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary px-4" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</button>
                            <button type="button" class="btn btn-primary px-4 btn-next" onclick="nextStep()">Lanjut & Simpan Draft <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div> 
                {{-- Penutup Step 3 --}}

                {{-- === STEP 4: ALAMAT === --}}
                <div class="tab-pane fade">
                    <h5 class="text-primary font-weight-bold mb-4">Langkah 4: Alamat</h5>
                    <div class="row">
                        <div class="col-md-12 mb-3"><label class="fw-bold">Alamat Lengkap</label><textarea name="alamat_jalan" class="form-control" rows="2"></textarea></div>
                        <div class="col-md-3 mb-3"><label>RT</label><input type="number" name="rt" class="form-control"></div>
                        <div class="col-md-3 mb-3"><label>RW</label><input type="number" name="rw" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Kode Pos</label><input type="number" name="kode_pos" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Desa/Kelurahan</label><input type="text" name="desa_kelurahan" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Kecamatan</label><input type="text" name="kecamatan" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Kabupaten/Kota</label><input type="text" name="kabupaten_kota" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Provinsi</label><input type="text" name="provinsi" class="form-control"></div>
                        <div class="col-md-12"><hr></div>
                        <div class="col-md-6 mb-3"><label class="fw-bold">Status Tinggal <span class="text-danger">*</span></label><select name="status_tinggal" id="jenis_tinggal" class="form-select" required><option value="Bersama Orang Tua">Bersama Orang Tua</option><option value="Wali">Wali</option><option value="Kos">Kos</option></select></div>
                        <div class="col-md-6 mb-3"><label>Jarak Sekolah</label><input type="text" name="jarak_sekolah" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Transportasi</label><input type="text" name="transportasi" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label class="fw-bold text-success">No HP/WA</label><input type="text" name="no_hp" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Email</label><input type="email" name="email" class="form-control"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary btn-exit-wizard shadow-sm"><i class="fas fa-times me-2"></i> Batal</a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary px-4" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</button>
                            <button type="button" class="btn btn-primary px-4 btn-next" onclick="nextStep()">Lanjut & Simpan Draft <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div> 
                {{-- Penutup Step 4 --}}

                {{-- === STEP 5: PENDIDIKAN === --}}
                <div class="tab-pane fade">
                    <h5 class="text-primary font-weight-bold mb-4">Langkah 5: Pendidikan</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="fw-bold">Kelas <span class="text-danger">*</span></label><select name="kelas_id" class="form-select" required><option value="">Pilih Kelas</option>@foreach($kelas as $k) <option value="{{$k->id}}">{{$k->nama_kelas}}</option> @endforeach</select></div>
                        <div class="col-md-6 mb-3"><label>Jurusan</label><select name="jurusan_id" class="form-select"><option value="">Pilih Jurusan</option>@foreach($jurusans as $j) <option value="{{$j->id}}">{{$j->nama_jurusan}}</option> @endforeach</select></div>
                        <div class="col-md-12 mt-3 mb-2 fw-bold text-dark border-bottom">Asal Sekolah</div>
                        <div class="col-md-6 mb-3"><label>Nama Sekolah Asal</label><input type="text" name="asal_sekolah_nama" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>NPSN</label><input type="text" name="asal_sekolah_npsn" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>No Ijazah</label><input type="text" name="no_ijazah" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Tanggal Lulus</label><input type="date" name="tgl_lulus" class="form-control"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary btn-exit-wizard shadow-sm"><i class="fas fa-times me-2"></i> Batal</a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary px-4" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</button>
                            <button type="button" class="btn btn-primary px-4 btn-next" onclick="nextStep()">Lanjut & Simpan Draft <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div> 
                {{-- Penutup Step 5 --}}

                {{-- === STEP 6: ORANG TUA === --}}
                <div class="tab-pane fade">
                    <h5 class="text-primary font-weight-bold mb-4">Langkah 6: Orang Tua</h5>
                    <div class="row">
                        <div class="col-md-6 border-end">
                            <h6 class="text-primary fw-bold">Ayah</h6>
                            <div class="mb-2"><label>Nama <span class="text-danger">*</span></label><input type="text" name="nama_ayah" class="form-control" required></div>
                            <div class="mb-2"><label>NIK</label><input type="number" name="nik_ayah" class="form-control"></div>
                            <div class="mb-2"><label>Pekerjaan</label><input type="text" name="pekerjaan_ayah" class="form-control"></div>
                            <div class="mb-2"><label>Penghasilan</label><input type="text" name="penghasilan_ayah" class="form-control"></div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success fw-bold">Ibu</h6>
                            <div class="mb-2"><label>Nama <span class="text-danger">*</span></label><input type="text" name="nama_ibu" class="form-control" required></div>
                            <div class="mb-2"><label>NIK</label><input type="number" name="nik_ibu" class="form-control"></div>
                            <div class="mb-2"><label>Pekerjaan</label><input type="text" name="pekerjaan_ibu" class="form-control"></div>
                            <div class="mb-2"><label>Penghasilan</label><input type="text" name="penghasilan_ibu" class="form-control"></div>
                        </div>
                        <div class="col-md-12 mt-4" id="section_wali" style="display: none;">
                            <div class="card bg-light border-warning"><div class="card-body"><h6 class="text-warning fw-bold">Wali</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2"><label>Nama Wali</label><input type="text" name="nama_wali" class="form-control"></div>
                                <div class="col-md-6 mb-2"><label>No HP</label><input type="text" name="no_hp_wali" class="form-control"></div>
                                <div class="col-md-6 mb-2"><label>Pekerjaan</label><input type="text" name="pekerjaan_wali" class="form-control"></div>
                                <div class="col-md-6 mb-2"><label>Hubungan</label><input type="text" name="hubungan_wali" class="form-control"></div>
                            </div></div></div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary btn-exit-wizard shadow-sm"><i class="fas fa-times me-2"></i> Batal</a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary px-4" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</button>
                            <button type="button" class="btn btn-primary px-4 btn-next" onclick="nextStep()">Lanjut & Simpan Draft <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div> 
                {{-- Penutup Step 6 --}}

                {{-- === STEP 7: KESEHATAN === --}}
                <div class="tab-pane fade">
                    <h5 class="text-primary font-weight-bold mb-4">Langkah 7: Kesehatan</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3"><label>Gol. Darah</label><select name="gol_darah" class="form-select"><option value="-">-</option><option value="A">A</option><option value="B">B</option><option value="O">O</option></select></div>
                        <div class="col-md-8 mb-3"><label>Riwayat Penyakit</label><input type="text" name="riwayat_penyakit" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label>Tinggi/Berat/Lingkar</label><div class="input-group"><input type="number" name="tinggi_badan" class="form-control" placeholder="cm"><input type="number" name="berat_badan" class="form-control" placeholder="kg"><input type="number" name="lingkar_kepala" class="form-control" placeholder="Lingkar cm"></div></div>
                        <div class="col-md-12 mb-3"><label>Berkebutuhan Khusus</label><select name="berkebutuhan_khusus" class="form-select mb-2"><option value="Tidak">Tidak</option><option value="Ya">Ya</option></select><input type="text" name="ket_berkebutuhan_khusus" class="form-control" placeholder="Keterangan..."></div>
                    </div>
                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary btn-exit-wizard shadow-sm"><i class="fas fa-times me-2"></i> Batal</a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary px-4" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</button>
                            <button type="button" class="btn btn-primary px-4 btn-next" onclick="nextStep()">Lanjut & Simpan Draft <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div> 
                {{-- Penutup Step 7 --}}

                {{-- === STEP 8: DOKUMEN === --}}
                <div class="tab-pane fade">
                    <h5 class="text-primary font-weight-bold mb-4">Langkah 8: Dokumen</h5>
                    <div class="row mb-4">
                        <div class="col-md-4"><label class="fw-bold">Foto Murid</label><div class="preview-box" id="prev_foto"><small>Preview</small></div><input type="file" name="foto" class="form-control" onchange="previewFile(this, 'prev_foto')"></div>
                        <div class="col-md-4"><label class="fw-bold">KK</label><div class="preview-box" id="prev_kk"><small>Preview</small></div><input type="file" name="file_kk" class="form-control" onchange="previewFile(this, 'prev_kk')"></div>
                        <div class="col-md-4"><label class="fw-bold">Akta</label><div class="preview-box" id="prev_akte"><small>Preview</small></div><input type="file" name="file_akte" class="form-control" onchange="previewFile(this, 'prev_akte')"></div>
                    </div>
                    <div class="row mb-4"><div class="col-md-6"><label>Ijazah</label><input type="file" name="file_ijazah" class="form-control"></div><div class="col-md-6"><label>Rapor</label><input type="file" name="file_rapor" class="form-control"></div></div>
                    
                    <div class="alert alert-info border-info">
                        <label class="fw-bold">Bantuan (KIP/PIP)</label>
                        <select name="bantuan_sekolah" id="status_bantuan" class="form-select w-auto d-inline-block ms-2"><option value="Tidak">Tidak</option><option value="Ya">Ya</option></select>
                        <div class="row mt-3" id="detail_bantuan" style="display: none;">
                            <div class="col-md-4"><input type="text" name="ket_bantuan_sekolah" class="form-control" placeholder="Jenis"></div>
                            <div class="col-md-4"><input type="text" name="no_bantuan" class="form-control" placeholder="No. Kartu"></div>
                            <div class="col-md-4"><input type="file" name="file_bantuan" class="form-control"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <a href="{{ route('admin.murid.index') }}" class="btn btn-secondary btn-exit-wizard shadow-sm"><i class="fas fa-times me-2"></i> Batal</a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary px-4" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</button>
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow"><i class="fas fa-save me-2"></i> SIMPAN SEMUA</button>
                        </div>
                    </div>
                </div> 
                {{-- Penutup Step 8 --}}

            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.lastNis = Number("{{ $lastNis ?? 0 }}");
    @if(session('saved'))
        Swal.fire({ title: 'Berhasil!', text: "{{ session('saved') }}", icon: 'success', confirmButtonText: 'OK' }).then((result) => { window.location.href = "{{ route('admin.murid.index') }}"; });
    @endif
</script>
@endpush