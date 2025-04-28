<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Hackathon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with(['hackathon', 'leader', 'members'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        $hackathons = Hackathon::where('is_active', true)
            ->where('event_start', '>', now())
            ->orderBy('event_start', 'asc')
            ->get();
        return view('teams.create', compact('hackathons'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'hackathon_id' => 'required|exists:hackathons,id',
            'description' => 'nullable|string',
            'max_members' => 'required|integer|min:1|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $team = new Team($request->all());
        $team->leader_id = auth()->id();
        $team->is_active = true;
        $team->code = Str::random(6);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('team-logos', 'public');
            $team->logo_url = $path;
        }

        $team->save();

        // Add the leader as a team member
        $team->members()->attach(auth()->id());

        return redirect()->route('teams.show', $team->id)
            ->with('success', 'Team created successfully!');
    }

    public function show(Team $team)
    {
        $team->load(['hackathon', 'leader', 'members']);
        return view('teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        if ($team->leader_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $hackathons = Hackathon::where('is_active', true)
            ->where('event_start', '>', now())
            ->orderBy('event_start', 'asc')
            ->get();
        return view('teams.edit', compact('team', 'hackathons'));
    }

    public function update(Request $request, Team $team)
    {
        if ($team->leader_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'hackathon_id' => 'required|exists:hackathons,id',
            'description' => 'nullable|string',
            'max_members' => 'required|integer|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $team->update($request->all());

        return redirect()->route('teams.show', $team->id)
            ->with('success', 'Team updated successfully!');
    }

    public function destroy(Team $team)
    {
        if ($team->leader_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $team->is_active = false;
        $team->save();

        return redirect()->route('teams')
            ->with('success', 'Team deleted successfully!');
    }

    public function join(Request $request, Team $team)
    {
        if ($team->isFull()) {
            return redirect()->back()
                ->with('error', 'Team is full.');
        }

        if ($team->members()->where('user_id', auth()->id())->exists()) {
            return redirect()->back()
                ->with('error', 'You are already a member of this team.');
        }

        $team->members()->attach(auth()->id());

        return redirect()->route('teams.show', $team->id)
            ->with('success', 'Successfully joined the team!');
    }

    public function leave(Team $team)
    {
        if ($team->leader_id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'Team leader cannot leave the team. Please transfer leadership or delete the team.');
        }

        $team->members()->detach(auth()->id());

        return redirect()->route('teams')
            ->with('success', 'Successfully left the team.');
    }

    public function removeMember(Team $team, User $user)
    {
        // Check if the current user is the team leader
        if (auth()->id() !== $team->leader_id) {
            abort(403, 'Only the team leader can remove members.');
        }

        // Check if the user is not the team leader
        if ($user->id === $team->leader_id) {
            abort(403, 'Cannot remove the team leader.');
        }

        // Check if the user is a member of the team
        if (!$team->members->contains($user->id)) {
            abort(404, 'User is not a member of this team.');
        }

        // Remove the user from the team
        $team->members()->detach($user->id);

        return redirect()->route('teams.show', $team->id)
            ->with('success', 'Member removed successfully.');
    }
} 