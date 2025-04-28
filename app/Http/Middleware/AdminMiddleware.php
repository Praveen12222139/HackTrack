<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->isOrganizer()) {
            return response()->json([
                'message' => 'Unauthorized. Only organizers can access this resource.',
            ], 403);
        }

        return $next($request);
    }
} 
