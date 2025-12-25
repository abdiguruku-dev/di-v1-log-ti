<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Http\Requests\StoreMuridRequest;
use App\Http\Requests\UpdateMuridRequest;
use App\Http\Requests\ImportMuridRequest;
use App\Services\MuridService;
use Illuminate\Support\Facades\DB;
use App\Imports\MuridImport;
use App\Exports\MuridExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF; // Pastikan library dompdf terinstall

class MuridController extends Controller
{
    protected $muridService;

    public function __construct(MuridService $muridService)
    {
        $this->muridService = $muridService;
    }

    // 1. INDEX + SEARCH
    public function index(Request $request)
    {
        $query = Murid::with(['kelas', 'jurusan'])->latest();

        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_lengkap', 'LIKE', "%{$keyword}%")
                  ->orWhere('nis', 'LIKE', "%{$keyword}%")
                  ->orWhere('nisn', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('kelas', function($qKelas) use ($keyword) {
                      $qKelas->where('nama_kelas', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        // PERBAIKAN DISINI:
        // JANGAN pakai $query->get(); <--- Ini penyebab error
        // GANTI jadi paginate(10); agar view bisa membaca halaman.
        $murids = $query->paginate(10); 

        return view('admin.kesiswaan.murid.index', compact('murids'));
    }

    // 2. CREATE
    public function create()
    {
        $kelas = DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();
        $jurusans = DB::table('jurusans')->get();
        $lastNis = Murid::max('nis') ?? 0;
        return view('admin.kesiswaan.murid.create', compact('kelas', 'jurusans', 'lastNis'));
    }

    // 3. STORE (Final)
    public function store(StoreMuridRequest $request)
    {
        $files = [
            'foto' => $request->file('foto'),
            'file_kk' => $request->file('file_kk'),
            'file_akte' => $request->file('file_akte'),
            'file_ijazah' => $request->file('file_ijazah'),
            'file_rapor' => $request->file('file_rapor'),
            'file_bantuan' => $request->file('file_bantuan'),
            'file_surat_mutasi' => $request->file('file_surat_mutasi'),
            'file_surat_kematian' => $request->file('file_surat_kematian'),
        ];
        $this->muridService->handleStore($request->validated(), $files);
        return redirect()->route('admin.murid.index')->with('success', 'Data Murid Berhasil Disimpan!');
    }

    // 4. SAVE DRAFT (Ajax)
    public function saveDraft(Request $request)
    {
        try {
            if ($request->step == 1 && !$request->id) {
                $request->validate(['jenis_pendaftaran' => 'required']);
            }
            if ($request->step == 2) {
                 $request->validate(['nama_lengkap' => 'required']);
            }

            $data = $request->except(['_token', 'step', 'id', 'foto', 'file_kk', 'file_akte', 'file_ijazah', 'file_rapor']);
            $data['input_progress'] = $request->step;

            if ($request->id) {
                $murid = Murid::findOrFail($request->id);
                $murid->update($data);
                $id = $murid->id;
            } else {
                $data['status_murid'] = 'Aktif'; 
                $murid = Murid::create($data);
                $id = $murid->id;
            }
            return response()->json(['status' => 'success', 'id' => $id]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // 5. EDIT, UPDATE, DESTROY, SHOW
    public function show($id)
    {
        $murid = Murid::with(['kelas', 'jurusan'])->findOrFail($id);
        // Jika view show belum ada, return json atau data dummy
        if (view()->exists('admin.kesiswaan.murid.show')) {
            return view('admin.kesiswaan.murid.show', compact('murid'));
        }
        return response()->json($murid);
    }

    public function edit($id)
    {
        $murid = Murid::findOrFail($id);
        $kelas = DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();
        $jurusans = DB::table('jurusans')->get();
        return view('admin.kesiswaan.murid.edit', compact('murid', 'kelas', 'jurusans'));
    }

    public function update(UpdateMuridRequest $request)
    {
        $this->muridService->handleUpdate($request->validated(), $request->id, $request->file('foto'));
        return back()->with('success', 'Data diperbarui!');
    }

    public function destroy($id)
    {
        $hapus = $this->muridService->handleDelete($id);
        return back()->with($hapus ? 'success' : 'error', $hapus ? 'Data dihapus.' : 'Gagal hapus.');
    }

    // 6. IMPORT EXCEL
    public function import(ImportMuridRequest $request)
    {
        try {
            Excel::import(new MuridImport, $request->file('file'));
            return redirect()->route('admin.murid.index')->with('success', 'Import berhasil!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $path = public_path('template/format_import_murid.xlsx');
        return file_exists($path) ? response()->download($path) : back()->with('error', 'Template tidak ditemukan.');
    }

    // 7. EXPORT EXCEL
    public function exportExcel()
    {
        return Excel::download(new MuridExport, 'data_murid_'.date('Y-m-d_H-i').'.xlsx');
    }

    // 8. EXPORT PDF
    public function exportPdf()
    {
        $murids = Murid::with(['kelas', 'jurusan'])->get();
        // Gunakan view index sebagai template PDF sementara
        $pdf = PDF::loadView('admin.kesiswaan.murid.index', compact('murids')); 
        // Agar rapi, sebaiknya buat file view baru: admin.kesiswaan.murid.print_pdf
        return $pdf->download('data_murid.pdf');
    }

} // <--- KURUNG TUTUP CLASS (JANGAN DIHAPUS)