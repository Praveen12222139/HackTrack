@extends('layouts.app')

@section('title', 'Create Team')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Create New Team</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Team Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hackathon_id" class="form-label">Hackathon</label>
                            <select class="form-select @error('hackathon_id') is-invalid @enderror" id="hackathon_id" name="hackathon_id" required>
                                <option value="">Select a hackathon</option>
                                @foreach($hackathons as $hackathon)
                                    <option value="{{ $hackathon->id }}" {{ old('hackathon_id') == $hackathon->id ? 'selected' : '' }}>
                                        {{ $hackathon->name }} ({{ $hackathon->event_start->format('M d, Y') }} - {{ $hackathon->event_end->format('M d, Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('hackathon_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="max_members" class="form-label">Maximum Team Size</label>
                            <input type="number" class="form-control @error('max_members') is-invalid @enderror" id="max_members" name="max_members" value="{{ old('max_members', 4) }}" min="2" max="10" required>
                            @error('max_members')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label">Team Logo</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Optional. Accepted formats: JPG, PNG, GIF. Maximum size: 2MB.
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('teams') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Team</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 