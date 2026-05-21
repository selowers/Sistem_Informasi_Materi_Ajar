<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function ensureAdminOnly()
    {
        $user = auth()->user();
        if ($user instanceof \App\Models\User && $user->isGuru()) {
            abort(403);
        }
    }
}
