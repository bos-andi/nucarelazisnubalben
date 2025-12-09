<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();
        
        if (!$user) {
            abort(403, 'Anda harus login terlebih dahulu.');
        }

        // Load permissions if not already loaded
        if (!$user->relationLoaded('permissions')) {
            $user->load('permissions');
        }

        // Superadmin memiliki semua permission
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Check if user has the required permission
        if (!$user->hasPermission($permission)) {
            abort(403, 'Anda tidak memiliki permission untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
