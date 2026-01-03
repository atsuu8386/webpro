<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{
    /**
     * Change the application locale
     */
    public function changeLocale(Request $request)
    {
        // Get locale from POST request
        $locale = $request->input('locale');

        $availableLocales = config('app.available_locales', ['en', 'vi']);

        if (in_array($locale, $availableLocales)) {
            // Set application locale
            App::setLocale($locale);

            // Set cookie for 1 year (525600 minutes)
            Cookie::queue('locale', $locale, 525600);
        }

        return redirect()->back();
    }
}
