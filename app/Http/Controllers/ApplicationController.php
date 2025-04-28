<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Hackathon;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with(['hackathon', 'team'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        $hackathons = Hackathon::where('is_active', true)
            ->where('event_start', '>', now())
            ->orderBy('event_start', 'asc')
            ->get();
        return view('applications.create', compact('hackathons'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hackathon_id' => 'required|exists:hackathons,id',
            'team_code' => 'nullable|string|exists:teams,code',
            'motivation' => 'required|string',
            'experience' => 'required|string',
            'skills' => 'required|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $hackathon = Hackathon::findOrFail($request->hackathon_id);

        if (!$hackathon->isRegistrationOpen()) {
            return redirect()->back()
                ->with('error', 'Registration is closed for this hackathon.')
                ->withInput();
        }

        $team = null;
        if ($request->has('team_code')) {
            $team = Team::where('code', $request->team_code)->first();
            if ($team->isFull()) {
                return redirect()->back()
                    ->with('error', 'Team is full.')
                    ->withInput();
            }
        }

        // Handle resume upload
        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        $application = Application::create([
            'user_id' => auth()->id(),
            'hackathon_id' => $hackathon->id,
            'team_id' => $team ? $team->id : null,
            'motivation' => $request->motivation,
            'experience' => $request->experience,
            'skills' => $request->skills,
            'status' => 'pending',
            'resume_url' => $resumePath,
        ]);

        if ($team && !$team->members()->where('user_id', auth()->id())->exists()) {
            $team->members()->attach(auth()->id());
        }

        return redirect()->route('applications.show', $application->id)
            ->with('success', 'Application submitted successfully!');
    }

    public function show(Application $application)
    {
        if ($application->user_id !== auth()->id() && !auth()->user()->isOrganizer()) {
            abort(403, 'Unauthorized action.');
        }

        $application->load(['hackathon', 'team', 'user']);
        return view('applications.show', compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        if (!auth()->user()->isOrganizer()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,accepted,rejected,waitlisted',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $application->update($request->all());

        return redirect()->route('applications.show', $application->id)
            ->with('success', 'Application status updated successfully!');
    }

    public function checkIn(Application $application)
    {
        if ($application->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($application->status !== 'accepted') {
            return redirect()->back()
                ->with('error', 'Only accepted applications can be checked in.');
        }

        $application->update(['is_checked_in' => true]);

        return redirect()->route('applications.show', $application->id)
            ->with('success', 'Check-in successful!');
    }

    public function downloadResume(Application $application)
    {
        if ($application->user_id !== auth()->id() && !auth()->user()->isOrganizer()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$application->resume_url) {
            return redirect()->back()
                ->with('error', 'No resume found for this application.');
        }

        return Storage::disk('public')->download($application->resume_url);
    }

    public function approve(Application $application)
    {
        if (!auth()->user()->isOrganizer()) {
            abort(403, 'Unauthorized action.');
        }

        $application->update([
            'status' => 'accepted',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id()
        ]);

        return redirect()->route('applications.show', $application->id)
            ->with('success', 'Application has been approved!');
    }

    public function reject(Application $application)
    {
        if (!auth()->user()->isOrganizer()) {
            abort(403, 'Unauthorized action.');
        }

        $application->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id()
        ]);

        return redirect()->route('applications.show', $application->id)
            ->with('success', 'Application has been rejected.');
    }
} 