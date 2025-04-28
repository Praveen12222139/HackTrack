@component('mail::message')
# Welcome to {{ config('app.name') }}!

Thank you for registering. Please verify your email address by clicking the button below.

@component('mail::button', ['url' => route('verification.verify', ['id' => $user->id, 'hash' => $hash])])
Verify Email Address
@endcomponent

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent 