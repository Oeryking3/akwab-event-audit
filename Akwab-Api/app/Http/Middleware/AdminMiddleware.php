<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $libelle = $user
            ? Role::where('id_role', $user->id_role)->value('libelle')
            : null;

        $isAdmin = in_array(
            mb_strtolower((string) $libelle),
            ['admin', 'administrateur'],
            true
        );

        if (! $isAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé'
            ], 403);
        }

        return $next($request);
    }
}