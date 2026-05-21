<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\JurnalPembelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class JurnalPembelajaranController extends Controller
{
    public function index()
    {
        $jurnals = JurnalPembelajaran::with(['guru','mataPelajaran','kelas'])->get();
        return view('jurnal_pembelajarans.index', compact('jurnals'));
    }

    public function create()
    {
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();
        return view('jurnal_pembelajarans.create', compact('gurus', 'mataPelajarans', 'kelas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal_pembelajaran' => 'required|date',
            'guru_id' => 'required|exists:gurus,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'materi_disampaikan' => 'required|string',
            'jumlah_hadir' => 'required|integer|min:0',
            'jumlah_tidak_hadir' => 'required|integer|min:0',
            'catatan_pembelajaran' => 'nullable|string',
            'kendala_pembelajaran' => 'nullable|string',
        ]);

        JurnalPembelajaran::create($data);

        return redirect()->route('jurnal_pembelajarans.index')->with('success', 'Data jurnal pembelajaran berhasil disimpan.');
    }

    public function edit(JurnalPembelajaran $jurnal_pembelajaran)
    {
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();
        return view('jurnal_pembelajarans.edit', compact('jurnal_pembelajaran', 'gurus', 'mataPelajarans', 'kelas'));
    }

    public function show(JurnalPembelajaran $jurnal_pembelajaran)
    {
        $jurnal_pembelajaran->load(['guru', 'mataPelajaran', 'kelas']);
        return view('jurnal_pembelajarans.show', compact('jurnal_pembelajaran'));
    }

    public function update(Request $request, JurnalPembelajaran $jurnal_pembelajaran)
    {
        $data = $request->validate([
            'tanggal_pembelajaran' => 'required|date',
            'guru_id' => 'required|exists:gurus,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'materi_disampaikan' => 'required|string',
            'jumlah_hadir' => 'required|integer|min:0',
            'jumlah_tidak_hadir' => 'required|integer|min:0',
            'catatan_pembelajaran' => 'nullable|string',
            'kendala_pembelajaran' => 'nullable|string',
        ]);

        $jurnal_pembelajaran->update($data);

        return redirect()->route('jurnal_pembelajarans.index')->with('success', 'Data jurnal pembelajaran berhasil diperbarui.');
    }

    public function destroy(JurnalPembelajaran $jurnal_pembelajaran)
    {
        $jurnal_pembelajaran->delete();

        return redirect()->route('jurnal_pembelajarans.index')->with('success', 'Data jurnal pembelajaran berhasil dihapus.');
    }
}
