<x-mail::message>

The OTP code for your account activation is {{ $user->otp_code }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
