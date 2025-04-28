@extends('layouts.app')

@section('title', 'Edit Team')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Edit Team</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('teams.update', $team->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Team Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $team->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hackathon_id" class="form-label">Hackathon</label>
                            <select name="hackathon_id" id="hackathon_id" class="form-select @error('hackathon_id') is-invalid @enderror" required>
                                <option value="">Select a hackathon</option>
                                @foreach($hackathons as $hackathon)
                                    <option value="{{ $hackathon->id }}" {{ old('hackathon_id', $team->hackathon_id) == $hackathon->id ? 'selected' : '' }}>
                                        {{ $hackathon->name }} ({{ $hackathon->event_start->format('M d, Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('hackathon_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $team->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="max_members" class="form-label">Maximum Team Size</label>
                            <input type="number" name="max_members" id="max_members" class="form-control @error('max_members') is-invalid @enderror" value="{{ old('max_members', $team->max_members) }}" min="2" max="10" required>
                            @error('max_members')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('teams.show', $team->id) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Team</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 