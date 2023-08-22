<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

class CheckTenant
{
    public function handle($request, Closure $next)
    {
        try {
            if (auth()->user()->hasRole('Tenant')) {
                return $next($request);
            } else {
                throw new Exception('You are not tenant');
            }
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }
}
