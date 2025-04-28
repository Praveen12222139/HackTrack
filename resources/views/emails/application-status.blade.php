@component('mail::message')
# Application Status Update

Your application for the hackathon "{{ $application->hackathon->title }}" has been {{ $application->status }}.

@if($application->status === 'approved')
    Congratulations! You have been approved to participate in the hackathon. You can now create or join a team.
@elseif($application->status === 'rejected')
    We regret to inform you that your application has been rejected. You can apply to other hackathons.
@endif

@component('mail::button', ['url' => route('applications.show', $application->id)])
View Application Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent 