<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

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
            'file_materi' => 'required|string|max:255',
            'tipe_file' => 'nullable|string|max:10',
            'deskripsi' => 'nullable|string',
        ]);

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
            'file_materi' => 'required|string|max:255',
            'tipe_file' => 'nullable|string|max:10',
            'deskripsi' => 'nullable|string',
        ]);

        $materi->update($data);

        return redirect()->route('materis.index')->with('success', 'Data materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        $materi->delete();

        return redirect()->route('materis.index')->with('success', 'Data materi berhasil dihapus.');
    }
}
