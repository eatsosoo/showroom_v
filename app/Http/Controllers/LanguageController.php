<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        abort_unless(array_key_exists($locale, config('localization.supported_locales')), 404);

        session(['locale' => $locale]);

        return back();
    }
}
