@extends('layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Application Details</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Hackathon</h5>
                            <p>{{ $application->hackathon->title }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Status</h5>
                            <span class="badge bg-{{ $application->status === 'pending' ? 'warning' : ($application->status === 'approved' ? 'success' : 'danger') }}">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Applicant</h5>
                            <p>{{ $application->user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Applied At</h5>
                            <p>{{ $application->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Motivation Letter</h5>
                        <p class="text-muted">{{ $application->motivation }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Skills</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(explode(',', $application->skills) as $skill)
                                <span class="badge bg-primary">{{ trim($skill) }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Experience</h5>
                        <p class="text-muted">{{ $application->experience }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Resume</h5>
                        <a href="{{ Storage::url($application->resume) }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-download"></i> Download Resume
                        </a>
                    </div>

                    @if(auth()->user()->role === 'organizer' && $application->status === 'pending')
                        <div class="d-flex gap-2">
                            <form action="{{ route('applications.approve', $application->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Approve Application</button>
                            </form>
                            <form action="{{ route('applications.reject', $application->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger">Reject Application</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 