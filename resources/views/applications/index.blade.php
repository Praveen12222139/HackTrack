@extends('layouts.app')

@section('title', 'Applications')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Applications</h3>
                    <a href="{{ route('applications.create') }}" class="btn btn-primary">New Application</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($applications->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted">You haven't submitted any applications yet.</p>
                            <a href="{{ route('applications.create') }}" class="btn btn-primary">Submit Your First Application</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Hackathon</th>
                                        <th>Team</th>
                                        <th>Status</th>
                                        <th>Submitted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $application->hackathon->name }}</td>
                                            <td>
                                                @if($application->team)
                                                    {{ $application->team->name }}
                                                @else
                                                    <span class="text-muted">No team</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $application->status === 'accepted' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('applications.show', $application->id) }}" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $applications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 