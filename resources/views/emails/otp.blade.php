<x-mail::message>
# Your 2FA Verification Code

Dear User,

Use the OTP below to enable Two-Factor Authentication on your account.

<x-mail::panel>
# {{ $otp }}
</x-mail::panel>

This code is valid for **10 minutes**. Do not share it with anyone.

If you did not request this, please ignore this email.

Thanks,
{{ config('app.name') }}
</x-mail::message>
