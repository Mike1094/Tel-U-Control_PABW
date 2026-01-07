<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
<<<<<<< HEAD
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;
        
        if (!in_array($userRole, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. You do not have permission to access this resource.'], 403);
            }
            abort(403, 'Unauthorized. You do not have permission to access this resource.');
        }

        return $next($request);
=======
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user memiliki salah satu dari role yang diizinkan
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        // Jika gagal, return 403 atau redirect
        abort(403, 'Akses Ditolak: Anda tidak memiliki izin.');
>>>>>>> 4cd04d578d3b87e47d112d6e41d12f317d5583a0
    }
}
