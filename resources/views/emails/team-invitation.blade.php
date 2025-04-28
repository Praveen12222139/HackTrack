@component('mail::message')
# Team Invitation

You have been invited to join the team "{{ $team->name }}" for the hackathon "{{ $team->hackathon->title }}".

@component('mail::panel')
Team Details:
- Team Name: {{ $team->name }}
- Hackathon: {{ $team->hackathon->title }}
- Current Members: {{ $team->members->count() }}/{{ $team->max_members }}
- Team Leader: {{ $team->leader->name }}
@endcomponent

@component('mail::button', ['url' => route('teams.show', $team->id)])
View Team Details
@endcomponent

@component('mail::button', ['url' => route('teams.accept-invitation', $team->id), 'color' => 'success'])
Accept Invitation
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent 