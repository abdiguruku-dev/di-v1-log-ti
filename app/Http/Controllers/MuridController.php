<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 1. IMPORT REQUEST (SATPAM VALIDASI)
use App\Http\Requests\StoreMuridRequest;
use App\Http\Requests\UpdateMuridRequest;
use App\Http\Requests\ImportMuridRequest;
// 2. IMPORT SERVICE (KOKI) - YANG BARU DITAMBAHKAN
use App\Services\MuridService;
// 3. IMPORT LAINNYA
use Illuminate\Support\Facades\DB;
use App\Imports\MuridImport;
use Maatwebsite\Excel\Facades\Excel;

class MuridController extends Controller
{
    // Properti untuk menyimpan Service
    protected $muridService;

    // CONSTRUCTOR: Ini wajib ada agar Service bisa dipakai
    public function __construct(MuridService $muridService)
    {
        $this->muridService = $muridService;
    }

    // INDEX: Tetap di Controller (Karena urusan View/Tampilan)
    public function index(Request $request)
    {
        $kelas = DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();
        $jurusans = DB::table('jurusans')->get();

        $query = DB::table('murids')
            ->leftJoin('kelas', 'murids.kelas_id', '=', 'kelas.id')
            ->leftJoin('jurusans', 'murids.jurusan_id', '=', 'jurusans.id')
            ->select('murids.*', 'kelas.nama_kelas', 'jurusans.kode_jurusan')
            ->where('status_murid', '=', 'Aktif');

        if ($request->has('filter_kelas') && $request->filter_kelas != '') {
            $query->where('murids.kelas_id', $request->filter_kelas);
        }

        if ($request->has('cari') && $request->cari != '') {
            $query->where('murids.nama_lengkap', 'like', '%' . $request->cari . '%');
        }

        $murids = $query->orderBy('kelas.nama_kelas', 'asc')
            ->orderBy('murids.nama_lengkap', 'asc')
            ->get();

        return view('admin.kesiswaan.murid.index', compact('murids', 'kelas', 'jurusans'));
    }

    // STORE: Sekarang tugasnya didelegasikan ke Service
    public function store(StoreMuridRequest $request)
    {
        // Panggil fungsi handleStore di MuridService
        $this->muridService->handleStore(
            $request->validated(), // Data input yang sudah bersih
            $request->file('foto') // File foto (jika ada)
        );

        return back()->with('success', 'Data Murid berhasil disimpan!');
    }

    // UPDATE: Delegasikan ke Service
    public function update(UpdateMuridRequest $request)
    {
        // Panggil fungsi handleUpdate di MuridService
        $this->muridService->handleUpdate(
            $request->validated(), 
            $request->id, 
            $request->file('foto')
        );

        return back()->with('success', 'Data Murid berhasil diperbarui!');
    }

    // DESTROY: Delegasikan ke Service
    public function destroy($id)
    {
        // Panggil fungsi handleDelete di MuridService
        $hapus = $this->muridService->handleDelete($id);

        if($hapus) {
            return back()->with('success', 'Data Murid dihapus.');
        } else {
            return back()->with('error', 'Data tidak ditemukan.');
        }
    }

    // IMPORT: Tetap di Controller (Pengecualian, karena pakai Library Excel)
    public function import(ImportMuridRequest $request)
    {
        try {
            Excel::import(new MuridImport, $request->file('file'));
            return redirect()->route('admin.murid.index')->with('success', 'Data murid berhasil diimport!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             return back()->with('error', 'Gagal Import: Data excel tidak valid.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $path = public_path('template/format_import_murid.xlsx');
        if (!file_exists($path)) {
            return back()->with('error', 'File template belum tersedia di server.');
        }
        return response()->download($path);
    }

    public function create()
    {
        // 1. Ambil data Kelas & Jurusan untuk Dropdown Pilihan
        $kelas = DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();
        $jurusans = DB::table('jurusans')->get();

        // 2. Tampilkan View Form
        return view('admin.kesiswaan.murid.create', compact('kelas', 'jurusans'));
    }
}