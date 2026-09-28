<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Vérifier employé connecté
        $employee = Auth::guard('employee')->user();

        // Vérifier admin connecté
        $admin = Auth::user();  // guard web

        // Si aucun utilisateur connecté → accès refusé
        if (!$employee && !$admin) {
            return redirect()->route('login'); // redirection admin par défaut
        }

        // *** Cas : ADMIN ***
        if ($admin) {
            // L’admin peut TOUT faire → pas besoin de rôle
            return $next($request);
        }

        // *** Cas : EMPLOYÉ ***
        if ($employee && in_array($employee->role, $roles)) {
            return $next($request);
        }

        return abort(403, 'Accès refusé.');
    }
}
