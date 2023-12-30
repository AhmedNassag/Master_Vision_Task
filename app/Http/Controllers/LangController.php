<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LangController extends Controller
{


    public function ar ()
    {
        App::setlocale('ar');

        Session::put('lang' , 'ar');

        return back();
    }

    public function en ()
    {
        App::setLocale('en');

        Session::put('lang' , 'en');

        return back();
    }
}
