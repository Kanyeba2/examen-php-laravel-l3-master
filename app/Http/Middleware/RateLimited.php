<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RateLimited
{
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()?->getName() ?? $request->path();
        $key = 'rate-limit:' . $request->ip() . ':' . $routeName;
        $count = cache()->get($key, 0);

        if ($count >= 10) {
            abort(429, 'Trop de requêtes. Veuillez réessayer plus tard.');
        }

        cache()->put($key, $count + 1, 60);

        return $next($request);
    }
}
