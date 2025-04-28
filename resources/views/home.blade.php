@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="jumbotron bg-light p-5 rounded-3 mb-4">
    <div class="container">
        <h1 class="display-4">Welcome to HackTrack</h1>
        <p class="lead">A complete administration system designed especially for hackathons and similar competitions.</p>
        <hr class="my-4">
        <p>Join exciting hackathons, form teams, and showcase your skills!</p>
        @guest
            <a class="btn btn-primary btn-lg" href="/register" role="button">Get Started</a>
        @else
            <a class="btn btn-primary btn-lg" href="/hackathons" role="button">Browse Hackathons</a>
        @endguest
    </div>
</div>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                    <h3 class="card-title">For Participants</h3>
                    <p class="card-text">Register easily with or without a team and confirm your attendance.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-trophy fa-3x mb-3 text-primary"></i>
                    <h3 class="card-title">For Organizers</h3>
                    <p class="card-text">Create your hackathon website, view registrations, and analyze statistics.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-3x mb-3 text-primary"></i>
                    <h3 class="card-title">Statistics</h3>
                    <p class="card-text">Track registration rates, decisions, and check-ins in real-time.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Upcoming Hackathons</h3>
                    <div class="list-group">
                        @foreach($upcomingHackathons as $hackathon)
                            <a href="/hackathons/{{ $hackathon->id }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $hackathon->name }}</h5>
                                    <small>{{ $hackathon->event_start->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">{{ Str::limit($hackathon->description, 100) }}</p>
                                <small>{{ $hackathon->location }}</small>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Active Teams</h3>
                    <div class="list-group">
                        @foreach($activeTeams as $team)
                            <a href="/teams/{{ $team->id }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $team->name }}</h5>
                                    <small>{{ $team->members->count() }}/{{ $team->max_members }} members</small>
                                </div>
                                <p class="mb-1">{{ Str::limit($team->description, 100) }}</p>
                                <small>Team Code: {{ $team->code }}</small>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 