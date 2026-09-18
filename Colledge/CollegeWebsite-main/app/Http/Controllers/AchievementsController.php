<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Graduate;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{

    public function index()
    {

        $achievements = Achievement::active()
            ->ordered()
            ->get()
            ->map(function ($achievement) {
                return $achievement;
            });

        $graduates = Graduate::active()
            ->ordered()
            ->get()
            ->map(function ($graduate) {

                return $graduate;
            });

        return view('achievements.index', [
            'achievements' => $achievements,
            'graduates' => $graduates,
        ]);
    }
}