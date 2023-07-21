@component('mail::message')
# Hello,

You have a new task <b>{{ $task->title }}</b> with deadline <b>{{ $task->deadline }}</b>.


Thanks,<br>
{{ config('app.name') }}
