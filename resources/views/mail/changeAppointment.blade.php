<x-mail::message>
Buna ziua {{$name}},

Te informam ca a fost modificata rezervarea din ziua de {{$oldDay}} la ora {{$oldHour}} in ziua de {{$day}}la ora {{$hour}}.

Multumim,<br>
{{ config('app.name') }}
</x-mail::message>
