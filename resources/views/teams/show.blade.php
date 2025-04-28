@extends('layouts.app')

@section('title', 'Team Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Team Details</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Team Name</h5>
                            <p>{{ $team->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Status</h5>
                            <span class="badge bg-{{ $team->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($team->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Hackathon</h5>
                            <p>{{ $team->hackathon->title }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Team Size</h5>
                            <p>{{ $team->members->count() }}/{{ $team->max_members }} members</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Description</h5>
                        <p class="text-muted">{{ $team->description }}</p>
                    </div>

                    @if($team->logo)
                        <div class="mb-4">
                            <h5>Team Logo</h5>
                            <img src="{{ Storage::url($team->logo) }}" alt="Team Logo" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5>Team Members</h5>
                        <div class="list-group">
                            @foreach($team->members as $member)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $member->name }}</strong>
                                        @if($member->id === $team->leader_id)
                                            <span class="badge bg-primary ms-2">Leader</span>
                                        @endif
                                    </div>
                                    @if(auth()->id() === $team->leader_id && $member->id !== $team->leader_id)
                                        <form action="{{ route('teams.remove-member', [$team->id, $member->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if($team->members->count() < $team->max_members && auth()->id() !== $team->leader_id && !$team->members->contains(auth()->id()))
                        <div class="mb-4">
                            <form action="{{ route('teams.join', $team->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Join Team</button>
                            </form>
                        </div>
                    @endif

                    @if(auth()->id() === $team->leader_id)
                        <div class="d-flex gap-2">
                            <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-primary">Edit Team</a>
                            <form action="{{ route('teams.destroy', $team->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Team</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 