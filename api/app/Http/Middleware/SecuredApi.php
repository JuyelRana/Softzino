<?php

namespace App\Http\Middleware;

use Closure;

class SecuredApi
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * Here I use APP_KEY = from env APP_NAME
         * APP_SECRET = from env APP_KEY
         * for just testing purpose, but we can use anything
         * according to requirements.
         */
        $app_key = $request->header('app-key');
        $app_secret = $request->header('app-secret');


        if (!$app_key || !$app_secret) {
            return response()->json(['message' => 'Please provide app key and app secret to access the api.'], 500);
        }

        if ($app_key != env('APP_NAME') || $app_secret != env('APP_KEY')) {
            return response()->json(['message' => 'Provided wrong app key or app secret.'], 500);
        }

        return $next($request);
    }
}
