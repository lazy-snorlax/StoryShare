@component('mail::message')
# Verify Your Email.

@if($newEmail)
You are receiving this email because a user has changed their account email to use this address.
@else
You are receiving this email because someone has registered an account with Story Share using this email address.
@endif

You can use the link below to verify your email address.

@component('mail::button', ['url' => $url])
Verify Email
@endcomponent

{{$url}}

@if($newEmail)
If you did not make this change you can ignore this email and the change will not be applied.
@else
If you did not create an account with Story Share you can ignore this email and the account will not be verified.
@endif
@endcomponent
