<!-- @extends('layouts.emails.main')

@section('content')
    @component('layouts.emails.components.table')
        @component('layouts.emails.components.table-row')
            Hi <strong>{{$email}}</strong>,
        @endcomponent

        @component('layouts.emails.components.table-row')
            Thanks for registering on LAZY NERD. Kindly verify your email address using this
            <a href="{{$url . '?token=' . $token}}">LINK</a> or click on the button below to continue using our site.
        @endcomponent

        @component('layouts.emails.components.table-row')
            @component('layouts.emails.components.button', ['link' => "$url?token=$token"])
                Verify Email
            @endcomponent
        @endcomponent
    @endcomponent
@endsection -->


@component('mail::message')
<p> Hi {{ $user->first_name }} {{ $user->last_name }}, </p>
Thanks for registering on LAZY NERD. Kindly verify your email address using this
            <a href="{{$url . '?token=' . $token}}">LINK</a> or click on the button below to continue using our site.
@component('mail::button', ['url' => config('settings.frontend_url') . '/reset-password?' . $urlQuery])
verify email
@endcomponent<p> If you’re having trouble with the
    button
    above, copy and paste the URL below into your web
    browser.</p>
<p><p>
@component('mail::panel')
<p>For security, If you did not request a password reset, please
    ignore this email or send a mail to {{ config('mail.from.address') }},
    if you have questions.</p>
@endcomponent {{ config('app.name') }} Team.
@endcomponent
