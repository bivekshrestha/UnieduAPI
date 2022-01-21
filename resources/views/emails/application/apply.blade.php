@component('mail::message')
    Dear Sir/Madame,

    We have sent you a new application of student: {{$student->detail->first_name}} {{$student->detail->last_name}}.

    Please, find the attachment below.

    Regards,
    {{ config('app.name') }}
@endcomponent
