<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\DB;

class LoggingMiddleware
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
        $response = $next($request);

        DB::table('logging')->insert([
            'request_user_agent' => $request->server('HTTP_USER_AGENT'),
            'request_path' => $request->server('REQUEST_URI'),
            'request_method' => $request->method(),
            'request_length' => $request->server('CONTENT_LENGTH'),
            'response_code' => $response->status(),
            'created_at' => Carbon::now()
        ]);
        return $response;
    }
}
