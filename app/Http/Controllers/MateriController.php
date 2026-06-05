<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    protected function currentUser(): ?User
    {
        return Auth::user();
    }

    public function index(Request $request)
    {
        $user = $this->currentUser();
        $search = trim($request->query('search', ''));

        $materis = Materi::with(['mataPelajaran', 'kelas', 'guru'])
            ->when($user && $user->isGuru() && $user->guru, function ($query) use ($user) {
                $query->where('guru_id', $user->guru->id);
            })
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

        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();
        $gurus = Guru::all();

        return view('materis.create', compact('mataPelajarans', 'kelas', 'gurus', 'currentGuru', 'guruNotLinked'));
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
                    'judul_materi' => 'required|string|max:150',
                    'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
                    'kelas_id' => 'required|exists:kelas,id',
                    'materi_pertemuan' => 'nullable|string|max:100',
                    'file_materi' => 'required|array|min:1',
                    'file_materi.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,bmp|max:51200',
                    'deskripsi' => 'nullable|string',
                ]);
                $data['guru_id'] = $currentGuru->id;
            } else {
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
                $selectedGuru = Guru::find($data['guru_id']);
                if ($selectedGuru && !$selectedGuru->user_id) {
                    $selectedGuru->user_id = $user->id;
                    $selectedGuru->save();
                }
            }
        } else {
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
        }

        $filePaths = [];
        if ($request->hasFile('file_materi')) {
            foreach ($request->file('file_materi') as $file) {
                $path = $file->store('materis', 'public');
                $filePaths[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getClientOriginalExtension(),
                ];
            }
        }

        $data['file_materi'] = json_encode($filePaths);

        Materi::create($data);

        return redirect()->route('materis.index')->with('success', 'Data materi berhasil disimpan.');
    }

    public function edit(Materi $materi)
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru() && (!$user->guru || $user->guru->id !== $materi->guru_id)) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah materi ini.');
        }

        $currentGuru = $user->isGuru() ? $user->guru : null;
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();
        $gurus = Guru::all();

        return view('materis.edit', compact('materi', 'mataPelajarans', 'kelas', 'gurus', 'currentGuru'));
    }

    public function show(Materi $materi)
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru() && (!$user->guru || $user->guru->id !== $materi->guru_id)) {
            abort(403, 'Anda tidak memiliki akses untuk melihat materi ini.');
        }

        $materi->load(['mataPelajaran', 'kelas', 'guru']);
        return view('materis.show', compact('materi'));
    }

    public function update(Request $request, Materi $materi)
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru() && (!$user->guru || $user->guru->id !== $materi->guru_id)) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah materi ini.');
        }

        if ($user->isGuru()) {
            $data = $request->validate([
                'judul_materi' => 'required|string|max:150',
                'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
                'kelas_id' => 'required|exists:kelas,id',
                'materi_pertemuan' => 'nullable|string|max:100',
                'file_materi' => 'nullable|array|min:1',
                'file_materi.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,bmp|max:51200',
                'deskripsi' => 'nullable|string',
            ]);
            $data['guru_id'] = $materi->guru_id;
        } else {
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
        }

        if ($request->hasFile('file_materi')) {
            $existingFiles = json_decode($materi->file_materi, true) ?? [];
            foreach ($request->file('file_materi') as $file) {
                $path = $file->store('materis', 'public');
                $existingFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getClientOriginalExtension(),
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
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru() && (!$user->guru || $user->guru->id !== $materi->guru_id)) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus materi ini.');
        }

        $materi->delete();

        return redirect()->route('materis.index')->with('success', 'Data materi berhasil dihapus.');
    }

    public function destroyFile(Materi $materi, $index)
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru() && (!$user->guru || $user->guru->id !== $materi->guru_id)) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus file materi ini.');
        }

        $files = json_decode($materi->file_materi, true) ?? [];

        if (!is_numeric($index) || !isset($files[$index])) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $file = $files[$index];

        if (!empty($file['path'])) {
            Storage::disk('public')->delete($file['path']);
        }

        array_splice($files, $index, 1);
        $materi->file_materi = json_encode($files);
        $materi->save();

        return back()->with('success', 'File berhasil dihapus.');
    }

    public function destroyFiles(Request $request, Materi $materi)
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru() && (!$user->guru || $user->guru->id !== $materi->guru_id)) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus file materi ini.');
        }

        $data = $request->validate([
            'indexes' => 'required|array|min:1',
            'indexes.*' => 'integer|min:0',
        ]);

        $indexes = $data['indexes'];
        $files = json_decode($materi->file_materi, true) ?? [];

        rsort($indexes);

        foreach ($indexes as $idx) {
            if (!isset($files[$idx])) {
                continue;
            }
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

    public function previewFile(Materi $materi, $index)
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru() && (!$user->guru || $user->guru->id !== $materi->guru_id)) {
            abort(403, 'Anda tidak memiliki akses untuk melihat file materi ini.');
        }

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
            'Content-Disposition' => 'inline; filename="' . ($file['name'] ?? basename($file['path'])) . '"',
        ]);
    }

    public function downloadFile(Materi $materi, $index)
    {
        $user = $this->currentUser();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isGuru() && (!$user->guru || $user->guru->id !== $materi->guru_id)) {
            abort(403, 'Anda tidak memiliki akses untuk mendownload file materi ini.');
        }

        $files = json_decode($materi->file_materi, true) ?? [];
        if (!is_numeric($index) || !isset($files[$index])) {
            abort(404);
        }
        $file = $files[$index];
        if (empty($file['path']) || !Storage::disk('public')->exists($file['path'])) {
            abort(404);
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');
        return $disk->download($file['path'], $file['name'] ?? basename($file['path']));
    }
}
