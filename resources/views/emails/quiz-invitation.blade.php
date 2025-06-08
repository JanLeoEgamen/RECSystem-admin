@component('mail::message')
# Quiz Invitation: {{ $quiz->title }}

Hello {{ $member->first_name }},

You have been invited to take the quiz: **{{ $quiz->title }}**

@if($quiz->description)
{{ $quiz->description }}
@endif

@if($quiz->time_limit)
**Time Limit:** {{ $quiz->time_limit }} seconds
@endif

@component('mail::button', ['url' => $url])
Take Quiz Now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent