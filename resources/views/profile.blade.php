@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">My Profile</h3>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row mb-5">
                        <div class="col-md-4 text-center">
                            <img src="{{ auth()->user()->avatar_url_full }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="rounded-circle"
                                 style="width: 180px; height: 180px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <h2 class="mb-3">{{ auth()->user()->name }}</h2>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-envelope text-muted me-2"></i>
                                <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar text-muted me-2"></i>
                                <p class="text-muted mb-0">Member since {{ auth()->user()->created_at->format('F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Section -->
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Application Status</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="applicationStatusChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Team Participation</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="teamParticipationChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">My Teams</h5>
                                </div>
                                <div class="card-body">
                                    @if(auth()->user()->teams->isEmpty())
                                        <div class="text-center py-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">You haven't joined any teams yet.</p>
                                            <a href="{{ route('teams') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Join a Team
                                            </a>
                                        </div>
                                    @else
                                        <div class="list-group">
                                            @foreach(auth()->user()->teams as $team)
                                                <a href="{{ route('teams.show', $team->id) }}" class="list-group-item list-group-item-action">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h6 class="mb-1">{{ $team->name }}</h6>
                                                        <small class="text-muted">{{ $team->hackathon->name }}</small>
                                                    </div>
                                                    <p class="mb-1">{{ Str::limit($team->description, 100) }}</p>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">My Applications</h5>
                                </div>
                                <div class="card-body">
                                    @if(auth()->user()->applications->isEmpty())
                                        <div class="text-center py-4">
                                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">You haven't submitted any applications yet.</p>
                                            <a href="{{ route('hackathons.index') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Apply to Hackathon
                                            </a>
                                        </div>
                                    @else
                                        <div class="list-group">
                                            @foreach(auth()->user()->applications as $application)
                                                <a href="{{ route('applications.show', $application->id) }}" class="list-group-item list-group-item-action">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h6 class="mb-1">{{ $application->hackathon->name }}</h6>
                                                        <span class="badge bg-{{ $application->status === 'accepted' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'warning') }}">
                                                            {{ ucfirst($application->status) }}
                                                        </span>
                                                    </div>
                                                    <p class="mb-1">Applied on {{ $application->created_at->format('M d, Y') }}</p>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Application Status Chart
    const applicationStatusCtx = document.getElementById('applicationStatusChart').getContext('2d');
    const applicationStatusData = {
        labels: ['Pending', 'Accepted', 'Rejected'],
        datasets: [{
            data: [
                {{ auth()->user()->applications->where('status', 'pending')->count() }},
                {{ auth()->user()->applications->where('status', 'accepted')->count() }},
                {{ auth()->user()->applications->where('status', 'rejected')->count() }}
            ],
            backgroundColor: ['#ffc107', '#28a745', '#dc3545'],
            borderWidth: 0
        }]
    };
    new Chart(applicationStatusCtx, {
        type: 'doughnut',
        data: applicationStatusData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });

    // Team Participation Chart
    const teamParticipationCtx = document.getElementById('teamParticipationChart').getContext('2d');
    const teamParticipationData = {
        labels: ['Team Leader', 'Team Member'],
        datasets: [{
            data: [
                {{ auth()->user()->ledTeams->count() }},
                {{ auth()->user()->teams->count() - auth()->user()->ledTeams->count() }}
            ],
            backgroundColor: ['#007bff', '#28a745'],
            borderWidth: 0
        }]
    };
    new Chart(teamParticipationCtx, {
        type: 'pie',
        data: teamParticipationData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection 