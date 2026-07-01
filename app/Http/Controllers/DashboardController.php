<?php

namespace App\Http\Controllers;

use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::count();

        $upcomingEvents = Event::where('status', 'upcomming')->count();

        $completedEvents = Event::where('status', 'completed')->count();

        $latestEvents = Event::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalEvents',
            'upcomingEvents',
            'completedEvents',
            'latestEvents'
        ));
    }
}