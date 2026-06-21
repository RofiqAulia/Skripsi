<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika user yang login memiliki role sebagai admin/mentor/pimpinan
        // maka redirect ke halaman admin panel (Filament)
        if ($user && $user->hasAnyRole(['super_admin', 'mentor', 'pimpinan'])) {
            return redirect('/admin');
        }

        return $next($request);
    }
}
