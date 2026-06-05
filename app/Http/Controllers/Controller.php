<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function ensureAdminOnly()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user instanceof \App\Models\User && $user->isGuru()) {
            abort(403);
        }
    }
}
