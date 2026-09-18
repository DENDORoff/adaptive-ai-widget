<?php

namespace App\Http\Controllers;

use App\Models\HistoryTimeline;
use Illuminate\Http\Request;

class AboutController extends Controller
{

    public function about()
    {
        $timelineEvents = HistoryTimeline::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get()
            ->map(function ($event) {

                return $event;
            });

        return view('pages.about', compact('timelineEvents'));
    }


    public function getTimelineEvents()
    {
        $events = HistoryTimeline::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->getTranslatedTitle(),
                    'description' => $event->getTranslatedDescription(),
                    'date' => $event->date->format('d.m.Y'),
                    'position' => $event->position,
                    'order' => $event->order,
                ];
            });

        return response()->json($events);
    }


    public function show($slug)
    {
        $event = HistoryTimeline::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.timeline-event', [
            'event' => $event,
            'title' => $event->getTranslatedTitle(),
            'description' => $event->getTranslatedDescription(),
        ]);
    }
}