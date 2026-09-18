<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function switch(string $locale)
    {

        if (!in_array($locale, ['ru', 'kk', 'en'])) {
            abort(404);
        }
        

        Session::put('locale', $locale);
        

        app()->setLocale($locale);
        
        return redirect()->back();
    }
}