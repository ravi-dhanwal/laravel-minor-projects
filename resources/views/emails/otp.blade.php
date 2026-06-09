@extends('emails.layout')
@php $headerSubtitle = 'Two-Factor Authentication'; @endphp

@section('content')
    <h2>🔐 Verification Code</h2>
    <p>Hi there! You have requested to enable <strong>Two-Factor Authentication</strong> on your account. Use the OTP below to proceed:</p>

    <div class="otp-box">
        <span>{{ $otp }}</span>
    </div>

    <div class="info-box">
        <p>⏱ This code is valid for <strong>10 minutes</strong>. Do not share it with anyone.</p>
    </div>

    <div class="warning">
        <p>🚨 If you did not request this, please ignore this email and change your password immediately.</p>
    </div>
@endsection
