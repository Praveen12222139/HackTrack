@extends('layouts.app')

@section('title', 'Teams')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Teams</h3>
                    <a href="{{ route('teams.create') }}" class="btn btn-primary">Create Team</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Team Name</th>
                                    <th>Hackathon</th>
                                    <th>Leader</th>
                                    <th>Members</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teams as $team)
                                    <tr>
                                        <td>{{ $team->name }}</td>
                                        <td>{{ $team->hackathon->name }}</td>
                                        <td>{{ $team->leader->name }}</td>
                                        <td>{{ $team->members->count() }}/{{ $team->max_members }}</td>
                                        <td>
                                            <span class="badge bg-{{ $team->is_active ? 'success' : 'secondary' }}">
                                                {{ $team->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('teams.show', $team->id) }}" class="btn btn-sm btn-info">View</a>
                                            @if(auth()->id() === $team->leader_id)
                                                <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No teams found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $teams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 