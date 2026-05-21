<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\JurnalPembelajaran;
use App\Models\Kurikulum;

class DashboardController extends Controller
{
    public function index()
    {
        $guruCount = Guru::count();
        $kelasCount = Kelas::count();
        $materiCount = Materi::count();
        $jurnalCount = JurnalPembelajaran::count();
        $kurikulumCount = Kurikulum::count();

        $user = auth()->user();
        if ($user instanceof \App\Models\User && $user->isGuru()) {
            return view('dashboard_guru', compact('guruCount', 'kelasCount', 'materiCount', 'jurnalCount', 'kurikulumCount'));
        }

        return view('dashboard', compact('guruCount', 'kelasCount', 'materiCount', 'jurnalCount'));
    }
}
