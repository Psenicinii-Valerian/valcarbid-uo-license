<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Apply the locale stored in the "locale" cookie to the current request.
     *
     * Falls back to the application's configured default locale when the cookie
     * is missing or holds an unsupported value. This only switches the display
     * language; it touches no application logic.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $available = array_keys(config('app.available_locales', ['en' => 'English']));

        $locale = $request->cookie('locale');

        if (in_array($locale, $available, true)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
