 @extends('layouts.emails.main')

@section('content')
    @component('layouts.emails.components.table')
        @component('layouts.emails.components.table-row')
        <p>  Hi {{$firstname}}  </p>
        @endcomponent

        @component('layouts.emails.components.table-row')
            Please find your OTP PIN below. This OTP is valid for the next 5 minutes.
        @endcomponent

        @component('layouts.emails.components.well')
            {{$token}}
        @endcomponent
    @endcomponent
@endsection  

