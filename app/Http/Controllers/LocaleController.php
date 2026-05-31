<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LocaleController extends Controller
{
    /**
     * Switch the application display language.
     *
     * Validates the requested locale against the supported set, stores the
     * choice in a long-lived cookie, and returns the user to the page they
     * came from. No other application state is modified.
     */
    public function switch(Request $request, string $locale)
    {
        $available = array_keys(config('app.available_locales', ['en' => 'English']));

        if (in_array($locale, $available, true)) {
            // Persist the choice for one year (525600 minutes).
            Cookie::queue('locale', $locale, 525600);
        }

        return redirect()->back();
    }
}
