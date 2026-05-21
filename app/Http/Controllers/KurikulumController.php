<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kurikulum;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    public function index()
    {
        $kurikulums = Kurikulum::with(['mataPelajaran','kelas'])->get();
        return view('kurikulums.index', compact('kurikulums'));
    }

    public function create()
    {
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();
        return view('kurikulums.create', compact('mataPelajarans', 'kelas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran' => 'required|string|max:20',
            'deskripsi' => 'nullable|string',
        ]);

        Kurikulum::create($data);

        return redirect()->route('kurikulums.index')->with('success', 'Data kurikulum berhasil disimpan.');
    }

    public function edit(Kurikulum $kurikulum)
    {
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();
        return view('kurikulums.edit', ['kurikulum' => $kurikulum, 'mataPelajarans' => $mataPelajarans, 'kelas' => $kelas]);
    }

    public function show(Kurikulum $kurikulum)
    {
        $kurikulum->load(['mataPelajaran', 'kelas']);
        return view('kurikulums.show', compact('kurikulum'));
    }

    public function update(Request $request, Kurikulum $kurikulum)
    {
        $data = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran' => 'required|string|max:20',
            'deskripsi' => 'nullable|string',
        ]);

        $kurikulum->update($data);

        return redirect()->route('kurikulums.index')->with('success', 'Data kurikulum berhasil diperbarui.');
    }

    public function destroy(Kurikulum $kurikulum)
    {
        $kurikulum->delete();

        return redirect()->route('kurikulums.index')->with('success', 'Data kurikulum berhasil dihapus.');
    }
}
