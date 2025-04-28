@extends('layouts.app')

@section('title', 'Hackathons')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Hackathons</h3>
                    @if(auth()->user()->role === 'organizer')
                        <a href="{{ route('hackathons.create') }}" class="btn btn-primary">Create Hackathon</a>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        @forelse($hackathons as $hackathon)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="{{ $hackathon->logo_url_full }}" 
                                         class="card-img-top" 
                                         alt="{{ $hackathon->name }}" 
                                         style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $hackathon->name }}</h5>
                                        <p class="card-text">{{ Str::limit($hackathon->description, 100) }}</p>
                                        <div class="mb-2">
                                            <span class="badge bg-{{ $hackathon->is_active ? 'success' : 'secondary' }}">
                                                {{ $hackathon->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar"></i> 
                                                {{ $hackathon->event_start->format('M d, Y') }} - {{ $hackathon->event_end->format('M d, Y') }}
                                            </small>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt"></i> {{ $hackathon->location }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('hackathons.show', $hackathon->id) }}" class="btn btn-primary">View Details</a>
                                        @if(auth()->user()->role === 'organizer')
                                            <a href="{{ route('hackathons.edit', $hackathon->id) }}" class="btn btn-secondary">Edit</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-center">No hackathons found.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $hackathons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 