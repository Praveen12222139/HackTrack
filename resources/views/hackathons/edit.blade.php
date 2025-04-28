@extends('layouts.app')

@section('title', 'Edit Hackathon')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Edit Hackathon</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('hackathons.update', $hackathon->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $hackathon->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $hackathon->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="event_start" class="form-label">Event Start Date</label>
                                    <input type="datetime-local" class="form-control @error('event_start') is-invalid @enderror" id="event_start" name="event_start" value="{{ old('event_start', $hackathon->event_start->format('Y-m-d\TH:i')) }}" required>
                                    @error('event_start')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="event_end" class="form-label">Event End Date</label>
                                    <input type="datetime-local" class="form-control @error('event_end') is-invalid @enderror" id="event_end" name="event_end" value="{{ old('event_end', $hackathon->event_end->format('Y-m-d\TH:i')) }}" required>
                                    @error('event_end')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="registration_start" class="form-label">Registration Start Date</label>
                                    <input type="datetime-local" class="form-control @error('registration_start') is-invalid @enderror" id="registration_start" name="registration_start" value="{{ old('registration_start', $hackathon->registration_start->format('Y-m-d\TH:i')) }}" required>
                                    @error('registration_start')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="registration_end" class="form-label">Registration End Date</label>
                                    <input type="datetime-local" class="form-control @error('registration_end') is-invalid @enderror" id="registration_end" name="registration_end" value="{{ old('registration_end', $hackathon->registration_end->format('Y-m-d\TH:i')) }}" required>
                                    @error('registration_end')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $hackathon->location) }}" required>
                            @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="website_url" class="form-label">Website URL</label>
                            <input type="url" class="form-control @error('website_url') is-invalid @enderror" id="website_url" name="website_url" value="{{ old('website_url', $hackathon->website_url) }}">
                            @error('website_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            @if($hackathon->logo_url)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $hackathon->logo_url) }}" alt="Current Logo" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                            @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">Leave empty to keep current logo. Accepted formats: JPG, PNG, GIF</small>
                        </div>

                        <div class="mb-3">
                            <label for="challenges" class="form-label">Challenges</label>
                            <textarea class="form-control @error('challenges') is-invalid @enderror" id="challenges" name="challenges" rows="3">{{ old('challenges', is_array($hackathon->challenges) ? implode("\n", $hackathon->challenges) : '') }}</textarea>
                            @error('challenges')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">Enter each challenge on a new line</small>
                        </div>

                        <div class="mb-3">
                            <label for="sponsors" class="form-label">Sponsors</label>
                            <textarea class="form-control @error('sponsors') is-invalid @enderror" id="sponsors" name="sponsors" rows="3">{{ old('sponsors', is_array($hackathon->sponsors) ? implode("\n", $hackathon->sponsors) : '') }}</textarea>
                            @error('sponsors')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">Enter each sponsor on a new line</small>
                        </div>

                        <div class="mb-3">
                            <label for="prizes" class="form-label">Prizes</label>
                            <textarea class="form-control @error('prizes') is-invalid @enderror" id="prizes" name="prizes" rows="3">{{ old('prizes', is_array($hackathon->prizes) ? implode("\n", $hackathon->prizes) : '') }}</textarea>
                            @error('prizes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">Enter each prize on a new line</small>
                        </div>

                        <div class="mb-3">
                            <label for="rules" class="form-label">Rules</label>
                            <textarea class="form-control @error('rules') is-invalid @enderror" id="rules" name="rules" rows="3">{{ old('rules', is_array($hackathon->rules) ? implode("\n", $hackathon->rules) : '') }}</textarea>
                            @error('rules')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">Enter each rule on a new line</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Hackathon</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 