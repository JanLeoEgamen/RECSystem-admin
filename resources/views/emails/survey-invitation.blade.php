@component('mail::message')
# Survey Invitation: {{ $survey->title }}

You have been invited to participate in a survey.

@component('mail::button', ['url' => $url])
Take Survey
@endcomponent

Thank you,<br>
{{ config('app.name') }}
@endcomponent