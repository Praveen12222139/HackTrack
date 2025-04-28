<?php

namespace App\Http\Controllers;

use App\Models\Hackathon;
use App\Models\Team;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $upcomingHackathons = Hackathon::where('is_active', true)
            ->where('event_start', '>', now())
            ->orderBy('event_start')
            ->take(5)
            ->get();

        $activeTeams = Team::where('is_active', true)
            ->withCount('members')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('home', compact('upcomingHackathons', 'activeTeams'));
    }
} 