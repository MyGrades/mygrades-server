<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check current environment
        if (App::environment() !== "development" && App::environment() !== "testing") {
            // check given credentials
            if ($request->getUser() !== config('app.api_user') || $request->getPassword() !== config('app.api_password')) {
                return response()->json(['error' => 'Invalid credentials.'], 401)
                    ->header('WWW-Authenticate', 'Basic');
            }
        }

        return $next($request);
    }
}
