<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\JurnalPembelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurnalPembelajaranController extends Controller
{
    protected function currentUser(): ?User
    {
        return Auth::user();
    }

    public function index(Request $request)
    {
        $user = $this->currentUser();
        $search = trim($request->query('search', ''));
        $tanggal = trim($request->query('tanggal', ''));

        $jurnals = JurnalPembelajaran::with(['guru', 'mataPelajaran', 'kelas'])
            ->when($user && $user->isGuru() && $user->guru, function ($query) use ($user) {
                $query->where('guru_id', $user->guru->id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('materi_disampaikan', 'like', "%{$search}%")
                      ->orWhere('catatan_pembelajaran', 'like', "%{$search}%")
                      ->orWhere('kendala_pembelajaran', 'like', "%{$search}%")
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
            ->when($tanggal, function ($query) use ($tanggal) {
                $query->whereDate('tanggal_pembelajaran', $tanggal);
            })
            ->orderByDesc('tanggal_pembelajaran')
            ->paginate(12);

        return view('jurnal_pembelajarans.index', compact('jurnals'));
    }

    public function create()
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        $currentGuru = null;
        $guruNotLinked = false;
        if ($user->isGuru()) {
            $currentGuru = $user->guru;
            if (!$currentGuru) {
                $guruNotLinked = true;
            }
        }

        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();

        return view('jurnal_pembelajarans.create', compact('gurus', 'mataPelajarans', 'kelas', 'currentGuru', 'guruNotLinked'));
    }

    public function store(Request $request)
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru()) {
            $currentGuru = $user->guru;
            if ($currentGuru) {
                $data = $request->validate([
                    'tanggal_pembelajaran' => 'required|date',
                    'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
                    'kelas_id' => 'required|exists:kelas,id',
                    'materi_disampaikan' => 'required|string',
                    'jumlah_hadir' => 'required|integer|min:0',
                    'jumlah_tidak_hadir' => 'required|integer|min:0',
                    'catatan_pembelajaran' => 'nullable|string',
                    'kendala_pembelajaran' => 'nullable|string',
                ]);
                $data['guru_id'] = $currentGuru->id;
            } else {
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
                $selectedGuru = Guru::find($data['guru_id']);
                if ($selectedGuru && !$selectedGuru->user_id) {
                    $selectedGuru->user_id = $user->id;
                    $selectedGuru->save();
                }
            }
        } else {
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
        }

        JurnalPembelajaran::create($data);

        return redirect()->route('jurnal_pembelajarans.index')->with('success', 'Data jurnal pembelajaran berhasil disimpan.');
    }

    public function edit(JurnalPembelajaran $jurnal_pembelajaran)
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru() && (!$user->guru || $user->guru->id !== $jurnal_pembelajaran->guru_id)) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah jurnal ini.');
        }

        $currentGuru = $user->isGuru() ? $user->guru : null;
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();

        return view('jurnal_pembelajarans.edit', compact('jurnal_pembelajaran', 'gurus', 'mataPelajarans', 'kelas', 'currentGuru'));
    }

    public function show(JurnalPembelajaran $jurnal_pembelajaran)
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru() && (!$user->guru || $user->guru->id !== $jurnal_pembelajaran->guru_id)) {
            abort(403, 'Anda tidak memiliki akses untuk melihat jurnal ini.');
        }

        $jurnal_pembelajaran->load(['guru', 'mataPelajaran', 'kelas']);
        return view('jurnal_pembelajarans.show', compact('jurnal_pembelajaran'));
    }

    public function update(Request $request, JurnalPembelajaran $jurnal_pembelajaran)
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru() && (!$user->guru || $user->guru->id !== $jurnal_pembelajaran->guru_id)) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah jurnal ini.');
        }

        if ($user->isGuru()) {
            $data = $request->validate([
                'tanggal_pembelajaran' => 'required|date',
                'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
                'kelas_id' => 'required|exists:kelas,id',
                'materi_disampaikan' => 'required|string',
                'jumlah_hadir' => 'required|integer|min:0',
                'jumlah_tidak_hadir' => 'required|integer|min:0',
                'catatan_pembelajaran' => 'nullable|string',
                'kendala_pembelajaran' => 'nullable|string',
            ]);
            $data['guru_id'] = $jurnal_pembelajaran->guru_id;
        } else {
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
        }

        $jurnal_pembelajaran->update($data);

        return redirect()->route('jurnal_pembelajarans.index')->with('success', 'Data jurnal pembelajaran berhasil diperbarui.');
    }

    public function destroy(JurnalPembelajaran $jurnal_pembelajaran)
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru() && (!$user->guru || $user->guru->id !== $jurnal_pembelajaran->guru_id)) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus jurnal ini.');
        }

        $jurnal_pembelajaran->delete();

        return redirect()->route('jurnal_pembelajarans.index')->with('success', 'Data jurnal pembelajaran berhasil dihapus.');
    }
}
