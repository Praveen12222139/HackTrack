<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hackathon;
use App\Models\Team;
use App\Models\Application;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'totalUsers' => User::count(),
            'activeHackathons' => Hackathon::where('is_active', true)->count(),
            'totalTeams' => Team::where('is_active', true)->count(),
            'pendingApplications' => Application::where('status', 'pending')->count(),
            'recentUsers' => User::latest()->take(5)->get(),
            'recentHackathons' => Hackathon::with('organizer')->latest()->take(5)->get(),
            'settings' => Setting::first(),
            'pendingApplicationsList' => Application::with(['user', 'hackathon'])
                ->where('status', 'pending')
                ->latest()
                ->get(),
        ];

        return view('admin.dashboard', $data);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string',
            'contact_email' => 'required|email',
            'max_team_size' => 'required|integer|min:2|max:10',
        ]);

        $settings = Setting::first() ?? new Setting();
        $settings->fill($validated);
        $settings->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Settings updated successfully!');
    }
} 