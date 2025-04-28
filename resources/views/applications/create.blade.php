@extends('layouts.app')

@section('title', 'New Application')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">New Application</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="hackathon_id" class="form-label">Hackathon</label>
                            <select name="hackathon_id" id="hackathon_id" class="form-select @error('hackathon_id') is-invalid @enderror" required>
                                <option value="">Select a hackathon</option>
                                @foreach($hackathons as $hackathon)
                                    <option value="{{ $hackathon->id }}" {{ old('hackathon_id') == $hackathon->id ? 'selected' : '' }}>
                                        {{ $hackathon->name }} ({{ $hackathon->event_start->format('M d, Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('hackathon_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="team_code" class="form-label">Team Code (Optional)</label>
                            <input type="text" name="team_code" id="team_code" class="form-control @error('team_code') is-invalid @enderror" value="{{ old('team_code') }}">
                            @error('team_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">If you're joining a team, enter the team code here.</small>
                        </div>

                        <div class="mb-3">
                            <label for="motivation" class="form-label">Motivation</label>
                            <textarea name="motivation" id="motivation" class="form-control @error('motivation') is-invalid @enderror" rows="4" required>{{ old('motivation') }}</textarea>
                            @error('motivation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Tell us why you want to participate in this hackathon.</small>
                        </div>

                        <div class="mb-3">
                            <label for="experience" class="form-label">Experience</label>
                            <textarea name="experience" id="experience" class="form-control @error('experience') is-invalid @enderror" rows="4" required>{{ old('experience') }}</textarea>
                            @error('experience')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Describe your relevant experience and background.</small>
                        </div>

                        <div class="mb-3">
                            <label for="skills" class="form-label">Skills</label>
                            <textarea name="skills" id="skills" class="form-control @error('skills') is-invalid @enderror" rows="4" required>{{ old('skills') }}</textarea>
                            @error('skills')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">List your technical skills and expertise.</small>
                        </div>

                        <div class="mb-3">
                            <label for="resume" class="form-label">Resume</label>
                            <input type="file" name="resume" id="resume" class="form-control @error('resume') is-invalid @enderror" required>
                            @error('resume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Upload your resume (PDF, DOC, or DOCX, max 2MB).</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('applications') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 