@extends('emails.layout')
@php $headerSubtitle = 'Admin Notification'; @endphp

@section('content')
    <h2>🆕 New User Registered</h2>
    <p>A new user has registered on your platform. Here are the details:</p>

    <div class="user-card">
        <div class="row">
            <span class="label">Name: </span>
            <span class="value"> {{ $user->name }}</span>
        </div>
        <div class="row">
            <span class="label">Email: </span>
            <span class="value"> {{ $user->email }}</span>
        </div>
        <div class="row">
            <span class="label">Role: </span>
            <span class="value"><span class="badge"> {{ ucfirst($user->role) }}</span></span>
        </div>
        <div class="row">
            <span class="label">Registered At: </span>
            <span class="value"> {{ $user->created_at->format('d M Y, h:i A') }}</span>
        </div>
    </div>

    <div class="info-box">
        <p>📊 Log in to the admin panel to manage and review new users.</p>
    </div>
@endsection
