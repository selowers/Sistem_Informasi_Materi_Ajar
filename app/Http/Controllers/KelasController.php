<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('waliKelas')->get();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $this->ensureAdminOnly();

        $gurus = Guru::all();
        return view('kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $this->ensureAdminOnly();

        $data = $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'wali_kelas_id' => 'nullable|exists:gurus,id',
            'tahun_ajaran' => 'required|string|max:20',
            'jumlah_santri' => 'required|integer|min:0',
        ]);

        Kelas::create($data);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil disimpan.');
    }

    public function edit(Kelas $kelas)
    {
        $this->ensureAdminOnly();

        $gurus = Guru::all();
        return view('kelas.edit', compact('kelas', 'gurus'));
    }

    public function show(Kelas $kelas)
    {
        $kelas->load('waliKelas');
        return view('kelas.show', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $this->ensureAdminOnly();

        $data = $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'wali_kelas_id' => 'nullable|exists:gurus,id',
            'tahun_ajaran' => 'required|string|max:20',
            'jumlah_santri' => 'required|integer|min:0',
        ]);

        $kelas->update($data);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        $this->ensureAdminOnly();

        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
