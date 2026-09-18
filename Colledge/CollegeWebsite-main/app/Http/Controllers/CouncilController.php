<?php

namespace App\Http\Controllers;

use App\Models\Council;
use Illuminate\Http\Request;

class CouncilController extends Controller
{

    public function index()
    {
        $councils = Council::with(['documents' => function($query) {
                $query->where('is_visible', true)
                      ->orderBy('order');
            }])
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->each(function ($council) {
                $council->documents_count = $council->documents->count();
            });

        return view('sovet.index', compact('councils'));
    }
}