@extends('layouts.emails.main')

@section('content')
    @component('layouts.emails.components.table')
        @component('layouts.emails.components.tableRow')
            Hi <strong>{{$username}}</strong>,
        @endcomponent

        @component('layouts.emails.components.tableRow')
            Thanks for registering on LAZY NERD. Kindly verify your email address using this
            <a href="{{$url . '?token=' . $token}}">LINK</a> or click on the button below to continue using our site.
        @endcomponent

        @component('layouts.emails.components.tableRow')
            @component('layouts.emails.components.button', ['link' => "$url?token=$token"])
                Verify Email
            @endcomponent
        @endcomponent
    @endcomponent
@endsection
