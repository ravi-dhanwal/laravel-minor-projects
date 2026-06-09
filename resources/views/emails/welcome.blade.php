@extends('emails.layout')
@php $headerSubtitle = 'Welcome Aboard!'; @endphp

@section('content')
    <h2>👋 Welcome, {{ $user->name }}!</h2>
    <p>Your account on <strong>{{ config('app.name') }}</strong> has been successfully created. We're glad to have you on board!</p>

    <div class="user-card">
        <div class="row">
            <span class="label">Name</span>
            <span class="value">{{ $user->name }}</span>
        </div>
        <div class="row">
            <span class="label">Email</span>
            <span class="value">{{ $user->email }}</span>
        </div>
        <div class="row">
            <span class="label">Role</span>
            <span class="value"><span class="badge">{{ ucfirst($user->role) }}</span></span>
        </div>
    </div>

    <div class="info-box">
        <p>💡 For added security, we recommend enabling <strong>Two-Factor Authentication</strong> from your profile settings.</p>
    </div>

    <p style="color:#718096; font-size:13px;">If you have any questions, feel free to reach out — we're always here to help.</p>
@endsection
