<?php

namespace App\Http\Controllers;

use App\Models\YouthEvent;
use App\Models\YouthClub;
use App\Models\YouthAnnouncement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class YouthMovementController extends Controller
{
    public function index()
    {
        try {

            $featuredEvent = YouthEvent::where('is_published', true)
                ->where('is_featured', true)
                ->where(function($query) {
                    $query->where('event_date', '>=', now()->subDay())
                          ->orWhereNull('event_date');
                })
                ->orderBy('event_date', 'desc')
                ->first();
            

            $upcomingEvents = YouthEvent::where('is_published', true)
                ->where('event_date', '>=', now())
                ->orderBy('event_date')
                ->limit(4)
                ->get()
                ->map(function ($event) {

                    return $event;
                });
            

            $eventsCount = YouthEvent::where('is_published', true)->count();
            $upcomingCount = YouthEvent::where('is_published', true)
                ->where('event_date', '>=', now())
                ->count();
            

            $clubs = YouthClub::where('is_published', true)
                ->where('is_recruiting', true)
                ->orderBy('is_featured', 'desc')
                ->orderBy('order')
                ->limit(8)
                ->get();
            

            $clubCategories = $clubs->pluck('category')->unique()->toArray();
            $clubsCount = YouthClub::where('is_published', true)->count();
            

            $participantsCount = YouthClub::where('is_published', true)->sum('current_participants');
            

            $announcements = YouthAnnouncement::where('is_published', true)
                ->orderBy('is_pinned', 'desc')
                ->orderByRaw(
                    "CASE priority 
                        WHEN 'urgent' THEN 1 
                        WHEN 'high' THEN 2 
                        WHEN 'normal' THEN 3 
                        WHEN 'low' THEN 4 
                        ELSE 5 
                    END"
                )
                ->orderBy('order')
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
            

            $currentMonth = Carbon::now();
            $monthName = $currentMonth->translatedFormat('F Y');
            

            $eventsByDate = YouthEvent::where('is_published', true)
                ->whereMonth('event_date', $currentMonth->month)
                ->whereYear('event_date', $currentMonth->year)
                ->get()
                ->map(function ($event) {

                    return $event;
                })
                ->groupBy(function($date) {
                    return Carbon::parse($date->event_date)->format('j');
                });
            
            return view('youth-movement.index', compact(
                'featuredEvent',
                'upcomingEvents',
                'eventsCount',
                'upcomingCount',
                'clubs',
                'clubCategories',
                'clubsCount',
                'participantsCount',
                'announcements',
                'monthName',
                'eventsByDate',
                'currentMonth'
            ));
            
        } catch (\Exception $e) {
            \Log::error('YouthMovementController error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            $currentMonth = Carbon::now();
            $monthName = $currentMonth->translatedFormat('F Y');
            
            return view('youth-movement.index', [
                'featuredEvent' => null,
                'upcomingEvents' => collect(),
                'eventsCount' => 0,
                'upcomingCount' => 0,
                'clubs' => collect(),
                'clubCategories' => [],
                'clubsCount' => 0,
                'participantsCount' => 0,
                'announcements' => collect(),
                'monthName' => $monthName,
                'eventsByDate' => collect(),
                'currentMonth' => $currentMonth
            ]);
        }
    }
}