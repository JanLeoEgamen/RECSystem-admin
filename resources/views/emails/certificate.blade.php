@component('mail::message')
# {{ $certificate->title }}

Dear {{ $member->first_name }} {{ $member->last_name }},

Please find attached your certificate that has been issued to you.

@component('mail::button', ['url' => route('home')])
Visit Our Website
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent