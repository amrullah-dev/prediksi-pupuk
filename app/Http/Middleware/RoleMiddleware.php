<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // ==========================
        // BELUM LOGIN
        // ==========================
        if (!Auth::check()) {

            return redirect()->route('login');

        }

        // ==========================
        // ROLE SESUAI
        // ==========================
        if (in_array(Auth::user()->role, $roles)) {

            return $next($request);

        }

        // ==========================
        // ROLE TIDAK SESUAI
        // ==========================
        return redirect()
            ->route('dashboard')
            ->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
    }
}