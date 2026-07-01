<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Pas connecté -> refusé
        if (! $request->user()) {
            abort(403, "Accès refusé.");
        }

        // L'admin a accès à tout
        if ($request->user()->isAdmin()) {
            return $next($request);
        }

        // Sinon, le rôle doit correspondre exactement
        if ($request->user()->role !== $role) {
            abort(403, "Accès non autorisé.");
        }

        return $next($request);
    }
}