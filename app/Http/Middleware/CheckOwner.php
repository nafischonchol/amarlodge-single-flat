<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

class CheckOwner
{
    public function handle($request, Closure $next)
    {
        try {
            if (! auth()->user()->hasRole('Tenant')) {
                return $next($request);
            } else {
                throw new Exception('You are not owner');
            }
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }
}
