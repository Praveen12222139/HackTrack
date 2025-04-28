<?php

namespace App\Http\Controllers;

use App\Models\Hackathon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HackathonController extends Controller
{
    public function index()
    {
        $hackathons = Hackathon::where('is_active', true)
            ->orderBy('event_start', 'asc')
            ->paginate(10);
        return view('hackathons.index', compact('hackathons'));
    }

    public function create()
    {
        if (!auth()->user()->isOrganizer()) {
            abort(403, 'Unauthorized action.');
        }
        return view('hackathons.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isOrganizer()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website_url' => 'nullable|url',
            'event_start' => 'required|date|after:now',
            'event_end' => 'required|date|after:event_start',
            'registration_start' => 'required|date|before:event_start',
            'registration_end' => 'required|date|after:registration_start|before:event_start',
            'location' => 'required|string|max:255',
            'challenges' => 'nullable|array',
            'sponsors' => 'nullable|array',
            'prizes' => 'nullable|array',
            'rules' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->storeAs('public/hackathon-logos', $logoName);
            $data['logo_url'] = 'hackathon-logos/' . $logoName;
        }

        $hackathon = Hackathon::create($data);
        $hackathon->is_active = true;
        $hackathon->save();

        return redirect()->route('hackathons.show', $hackathon->id)
            ->with('success', 'Hackathon created successfully!');
    }

    public function show(Hackathon $hackathon)
    {
        return view('hackathons.show', compact('hackathon'));
    }

    public function edit(Hackathon $hackathon)
    {
        if (!auth()->user()->isOrganizer()) {
            abort(403, 'Unauthorized action.');
        }
        return view('hackathons.edit', compact('hackathon'));
    }

    public function update(Request $request, Hackathon $hackathon)
    {
        if (!auth()->user()->isOrganizer()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website_url' => 'nullable|url',
            'event_start' => 'required|date|after:now',
            'event_end' => 'required|date|after:event_start',
            'registration_start' => 'required|date|before:event_start',
            'registration_end' => 'required|date|after:registration_start|before:event_start',
            'location' => 'required|string|max:255',
            'challenges' => 'nullable|array',
            'sponsors' => 'nullable|array',
            'prizes' => 'nullable|array',
            'rules' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($hackathon->logo_url) {
                Storage::disk('public')->delete($hackathon->logo_url);
            }
            
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->storeAs('public/hackathon-logos', $logoName);
            $data['logo_url'] = 'hackathon-logos/' . $logoName;
        }

        $hackathon->update($data);

        return redirect()->route('hackathons.show', $hackathon->id)
            ->with('success', 'Hackathon updated successfully!');
    }

    public function destroy(Hackathon $hackathon)
    {
        if (!auth()->user()->isOrganizer()) {
            abort(403, 'Unauthorized action.');
        }

        $hackathon->is_active = false;
        $hackathon->save();

        return redirect()->route('hackathons')
            ->with('success', 'Hackathon deleted successfully!');
    }

    public function statistics(Hackathon $hackathon)
    {
        if (!auth()->user()->isOrganizer()) {
            abort(403, 'Unauthorized action.');
        }

        $statistics = [
            'total_applications' => $hackathon->applications()->count(),
            'accepted_applications' => $hackathon->applications()->where('status', 'accepted')->count(),
            'rejected_applications' => $hackathon->applications()->where('status', 'rejected')->count(),
            'waitlisted_applications' => $hackathon->applications()->where('status', 'waitlisted')->count(),
            'checked_in_applications' => $hackathon->applications()->where('is_checked_in', true)->count(),
        ];

        return view('hackathons.statistics', compact('hackathon', 'statistics'));
    }
} 