<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $availableLocales = config('app.available_locales', ['en', 'vi']);

        // Priority 1: Check cookie (persistent across sessions)
        $cookieLocale = $request->cookie('locale');
        if ($cookieLocale && in_array($cookieLocale, $availableLocales)) {
            $locale = $cookieLocale;
        } else {
            // Priority 2: Use default locale from config
            $locale = config('app.locale', 'vi');
        }

        // Set the application locale
        App::setLocale($locale);

        return $next($request);
    }
}
