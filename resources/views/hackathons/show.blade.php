@extends('layouts.app')

@section('title', $hackathon->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ $hackathon->logo_url_full }}" 
                                 alt="{{ $hackathon->name }}" 
                                 class="rounded me-3"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            <h3 class="mb-0">{{ $hackathon->name }}</h3>
                        </div>
                        <span class="badge bg-{{ $hackathon->is_active ? 'success' : 'secondary' }}">
                            {{ $hackathon->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Description</h5>
                            <p>{{ $hackathon->description }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Location</h5>
                            <p>{{ $hackathon->location }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Event Dates</h5>
                            <p>
                                Start: {{ $hackathon->event_start->format('M d, Y H:i') }}<br>
                                End: {{ $hackathon->event_end->format('M d, Y H:i') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Registration Period</h5>
                            <p>
                                Start: {{ $hackathon->registration_start->format('M d, Y H:i') }}<br>
                                End: {{ $hackathon->registration_end->format('M d, Y H:i') }}
                            </p>
                        </div>
                    </div>

                    @if($hackathon->challenges)
                        <div class="mb-4">
                            <h5>Challenges</h5>
                            <ul>
                                @foreach($hackathon->challenges as $challenge)
                                    <li>{{ $challenge }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($hackathon->sponsors)
                        <div class="mb-4">
                            <h5>Sponsors</h5>
                            <ul>
                                @foreach($hackathon->sponsors as $sponsor)
                                    <li>{{ $sponsor }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($hackathon->prizes)
                        <div class="mb-4">
                            <h5>Prizes</h5>
                            <ul>
                                @foreach($hackathon->prizes as $prize)
                                    <li>{{ $prize }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($hackathon->rules)
                        <div class="mb-4">
                            <h5>Rules</h5>
                            <ul>
                                @foreach($hackathon->rules as $rule)
                                    <li>{{ $rule }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        @if($hackathon->website_url)
                            <a href="{{ $hackathon->website_url }}" class="btn btn-primary" target="_blank">Visit Website</a>
                        @endif
                        @if(auth()->user()->role === 'participant' && $hackathon->is_active)
                            <a href="{{ route('applications.create', ['hackathon_id' => $hackathon->id]) }}" class="btn btn-success">Apply Now</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 