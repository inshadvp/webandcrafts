@component('mail::message')
# Hello {{ $employee->name }}

Your password is <b>{{ $employee->random_password }}</b>

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
