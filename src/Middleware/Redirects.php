<?php

namespace Leaguefy\LeaguefyAdmin\Middleware;

use Closure;
use Illuminate\Http\Request;

class Redirects
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->getStatusCode() === 302 && in_array($request->method(), ['PUT', 'PATCH', 'DELETE'])) {
            $response->setStatusCode(303);
        }

        return $response;
    }
}
