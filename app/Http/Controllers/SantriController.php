<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Santri;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function index()
    {
        $santris = Santri::with('kelas')->get();
        return view('santris.index', compact('santris'));
    }

    public function create()
    {
        $this->ensureAdminOnly();

        $kelas = Kelas::all();
        return view('santris.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $this->ensureAdminOnly();

        $data = $request->validate([
            'nama_santri' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'nama_orang_tua' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        Santri::create($data);

        return redirect()->route('santris.index')->with('success', 'Data santri berhasil disimpan.');
    }

    public function edit(Santri $santri)
    {
        $this->ensureAdminOnly();

        $kelas = Kelas::all();
        return view('santris.edit', compact('santri', 'kelas'));
    }

    public function show(Santri $santri)
    {
        $santri->load('kelas');
        return view('santris.show', compact('santri'));
    }

    public function update(Request $request, Santri $santri)
    {
        $this->ensureAdminOnly();

        $data = $request->validate([
            'nama_santri' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'nama_orang_tua' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $santri->update($data);

        return redirect()->route('santris.index')->with('success', 'Data santri berhasil diperbarui.');
    }

    public function destroy(Santri $santri)
    {
        $this->ensureAdminOnly();

        $santri->delete();

        return redirect()->route('santris.index')->with('success', 'Data santri berhasil dihapus.');
    }
}
