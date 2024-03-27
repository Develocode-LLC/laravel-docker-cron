<x-mail::message>
# Hello, {{ $user->first_name }}!

Thank you for signing up for a trip with us. Please use the following verification code to finish registering your account.

<x-mail::panel>
    {{ $user->registration_key }}
</x-mail::panel>

<x-mail::button :url="$url" color="primary">
Continue Registration
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
