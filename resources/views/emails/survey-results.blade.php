@component('mail::message')
# Survey Results: {{ $survey->title }}

Thank you for completing our survey. Here are your responses:

@component('mail::panel')
@foreach($response->answers as $answer)
**{{ $answer->question->question }}**  
{{ $answer->answer }}

@endforeach
@endcomponent

Thank you,<br>
{{ config('app.name') }}
@endcomponent