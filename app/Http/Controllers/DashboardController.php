<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\JurnalPembelajaran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $guruCount = Guru::count();
        $kelasCount = Kelas::count();
        $materiCount = Materi::count();
        $jurnalCount = JurnalPembelajaran::count();

        $user = Auth::user();
        if ($user instanceof \App\Models\User && $user->isGuru()) {
            return view('dashboard_guru', compact('guruCount', 'kelasCount', 'materiCount', 'jurnalCount'));
        }

        return view('dashboard', compact('guruCount', 'kelasCount', 'materiCount', 'jurnalCount'));
    }
}
