@component('mail::message')
# Welcome to How To Help

Thank you for signing up.

@component('mail::button', ['url' => config('app.url')])
Go to How To Help
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
