@component('mail::message')
# Quiz Results: {{ $quiz->title }}

Hello {{ $member->first_name }},

Here are your results for the quiz: **{{ $quiz->title }}**

**Score:** {{ $attempt->score }} out of {{ $quiz->questions->sum('points') }}

**Completed At:** {{ \Carbon\Carbon::parse($attempt->completed_at)->format('F j, Y g:i a') }}

@component('mail::button', ['url' => route('quiz.results', $attempt->id)])
View Detailed Results
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent