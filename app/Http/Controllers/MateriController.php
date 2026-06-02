<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));

        $materis = Materi::with(['mataPelajaran','kelas','guru'])
            ->when($search, function ($query) use ($search) {
                $query->where('judul_materi', 'like', "%{$search}%")
                      ->orWhere('file_materi', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%")
                      ->orWhereHas('guru', function ($query) use ($search) {
                          $query->where('nama_guru', 'like', "%{$search}%");
                      })
                      ->orWhereHas('mataPelajaran', function ($query) use ($search) {
                          $query->where('nama_mapel', 'like', "%{$search}%");
                      })
                      ->orWhereHas('kelas', function ($query) use ($search) {
                          $query->where('nama_kelas', 'like', "%{$search}%");
                      });
            })
            ->get();

        return view('materis.index', compact('materis'));
    }

    public function create()
    {
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();
        $gurus = Guru::all();
        return view('materis.create', compact('mataPelajarans', 'kelas', 'gurus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul_materi' => 'required|string|max:150',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:gurus,id',
            'materi_pertemuan' => 'nullable|string|max:100',
            'file_materi' => 'required|array|min:1',
            'file_materi.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,bmp|max:51200',
            'deskripsi' => 'nullable|string',
        ]);

        // Handle multiple file uploads
        $filePaths = [];
        if ($request->hasFile('file_materi')) {
            foreach ($request->file('file_materi') as $file) {
                $path = $file->store('materis', 'public');
                $filePaths[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getClientOriginalExtension()
                ];
            }
        }

        $data['file_materi'] = json_encode($filePaths);

        Materi::create($data);

        return redirect()->route('materis.index')->with('success', 'Data materi berhasil disimpan.');
    }

    public function edit(Materi $materi)
    {
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();
        $gurus = Guru::all();
        return view('materis.edit', compact('materi', 'mataPelajarans', 'kelas', 'gurus'));
    }

    public function show(Materi $materi)
    {
        $materi->load(['mataPelajaran', 'kelas', 'guru']);
        return view('materis.show', compact('materi'));
    }

    public function update(Request $request, Materi $materi)
    {
        $data = $request->validate([
            'judul_materi' => 'required|string|max:150',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:gurus,id',
            'materi_pertemuan' => 'nullable|string|max:100',
            'file_materi' => 'nullable|array|min:1',
            'file_materi.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,bmp|max:51200',
            'deskripsi' => 'nullable|string',
        ]);

        // Handle file uploads jika ada file baru
        if ($request->hasFile('file_materi')) {
            // Ambil file lama
            $existingFiles = json_decode($materi->file_materi, true) ?? [];
            
            // Tambah file baru ke file lama
            foreach ($request->file('file_materi') as $file) {
                $path = $file->store('materis', 'public');
                $existingFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getClientOriginalExtension()
                ];
            }
            $data['file_materi'] = json_encode($existingFiles);
        } else {
            unset($data['file_materi']);
        }

        $materi->update($data);

        return redirect()->route('materis.index')->with('success', 'Data materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        $materi->delete();

        return redirect()->route('materis.index')->with('success', 'Data materi berhasil dihapus.');
    }

    /**
     * Hapus satu file dari materi (by index)
     */
    public function destroyFile(Materi $materi, $index)
    {
        $files = json_decode($materi->file_materi, true) ?? [];

        if (!is_numeric($index) || !isset($files[$index])) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $file = $files[$index];

        // Hapus file fisik jika ada
        if (!empty($file['path'])) {
            Storage::disk('public')->delete($file['path']);
        }

        // Hapus dari array dan simpan
        array_splice($files, $index, 1);
        $materi->file_materi = json_encode($files);
        $materi->save();

        return back()->with('success', 'File berhasil dihapus.');
    }

    /**
     * Hapus beberapa file sekaligus berdasarkan index array
     */
    public function destroyFiles(Request $request, Materi $materi)
    {
        $data = $request->validate([
            'indexes' => 'required|array|min:1',
            'indexes.*' => 'integer|min:0'
        ]);

        $indexes = $data['indexes'];
        $files = json_decode($materi->file_materi, true) ?? [];

        // Urutkan index descending agar penghapusan tidak mengubah posisi index berikutnya
        rsort($indexes);

        foreach ($indexes as $idx) {
            if (!isset($files[$idx])) continue;
            $file = $files[$idx];
            if (!empty($file['path'])) {
                Storage::disk('public')->delete($file['path']);
            }
            array_splice($files, $idx, 1);
        }

        $materi->file_materi = json_encode(array_values($files));
        $materi->save();

        return back()->with('success', 'File terpilih berhasil dihapus.');
    }

    /**
     * Preview file via controller (serve inline)
     */
    public function previewFile(Materi $materi, $index)
    {
        $files = json_decode($materi->file_materi, true) ?? [];
        if (!is_numeric($index) || !isset($files[$index])) {
            abort(404);
        }
        $file = $files[$index];
        if (empty($file['path']) || !Storage::disk('public')->exists($file['path'])) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($file['path']);
        return response()->file($fullPath, [
            'Content-Disposition' => 'inline; filename="' . ($file['name'] ?? basename($file['path'])) . '"'
        ]);
    }

    /**
     * Download file via controller
     */
    public function downloadFile(Materi $materi, $index)
    {
        $files = json_decode($materi->file_materi, true) ?? [];
        if (!is_numeric($index) || !isset($files[$index])) {
            abort(404);
        }
        $file = $files[$index];
        if (empty($file['path']) || !Storage::disk('public')->exists($file['path'])) {
            abort(404);
        }

        return Storage::disk('public')->download($file['path'], $file['name'] ?? basename($file['path']));
    }
}
