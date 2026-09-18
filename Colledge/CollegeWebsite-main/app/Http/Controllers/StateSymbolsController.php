<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StateSymbolsController extends Controller
{
    public function index()
    {
        return view('state-symbols.index');
    }
}