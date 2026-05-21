<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with(['mataPelajaran','user'])->get();
        return view('gurus.index', compact('gurus'));
    }

    public function create()
    {
        $this->ensureAdminOnly();

        $users = User::all();

        return view('gurus.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->ensureAdminOnly();

        $data = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'mata_pelajaran_nama' => 'required|string|max:100',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $mataPelajaran = MataPelajaran::firstOrCreate(
            ['nama_mapel' => $data['mata_pelajaran_nama']],
            ['deskripsi' => null]
        );

        $data['mata_pelajaran_id'] = $mataPelajaran->id;
        unset($data['mata_pelajaran_nama']);

        Guru::create($data);

        return redirect()->route('gurus.index')->with('success', 'Data guru berhasil disimpan.');
    }

    public function edit(Guru $guru)
    {
        $this->ensureAdminOnly();

        $users = User::all();

        return view('gurus.edit', compact('guru', 'users'));
    }

    public function update(Request $request, Guru $guru)
    {
        $this->ensureAdminOnly();

        $data = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'mata_pelajaran_nama' => 'required|string|max:100',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $mataPelajaran = MataPelajaran::firstOrCreate(
            ['nama_mapel' => $data['mata_pelajaran_nama']],
            ['deskripsi' => null]
        );

        $data['mata_pelajaran_id'] = $mataPelajaran->id;
        unset($data['mata_pelajaran_nama']);

        $guru->update($data);

        return redirect()->route('gurus.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function show(Guru $guru)
    {
        $guru->load(['mataPelajaran', 'user']);

        return view('gurus.show', compact('guru'));
    }

    public function destroy(Guru $guru)
    {
        $this->ensureAdminOnly();

        $guru->delete();

        return redirect()->route('gurus.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
