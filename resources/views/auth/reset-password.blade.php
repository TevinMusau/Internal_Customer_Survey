@extends('layouts.app')

@section('title') Reset Password @endsection

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2family=Playfair+Display:wght@500&family=DM+Sans:wght@300;400;500&display=swap');

    .reset-page {
        min-height: 100vh;
        background: #f4f7f7;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        font-family: 'DM Sans', sans-serif;
    }

    .reset-card {
        background: #fff;
        border: 1px solid #e8eded;
        border-radius: 16px;
        width: 100%;
        max-width: 420px;
        padding: 2.5rem 2.5rem 2rem;
        animation: slideUp .45s cubic-bezier(.16,1,.3,1) both;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .reset-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #E1F5EE;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
    }

    .reset-icon svg {
        width: 22px;
        height: 22px;
        stroke: #0F6E56;
        fill: none;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .reset-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 500;
        color: #1a1a2e;
        margin-bottom: .35rem;
    }

    .reset-subtitle {
        font-size: .875rem;
        color: #6b7280;
        font-weight: 300;
        line-height: 1.6;
        margin-bottom: 1.75rem;
    }

    .field-label {
        font-size: .72rem;
        font-weight: 500;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #6b7280;
        display: block;
        margin-bottom: .35rem;
    }

    .field-wrap {
        position: relative;
        margin-bottom: 1.1rem;
    }

    .field-wrap .field-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 15px;
        height: 15px;
        stroke: #9ca3af;
        fill: none;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
        pointer-events: none;
    }

    .reset-input {
        width: 100%;
        padding: .65rem 1rem .65rem 2.25rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: .88rem;
        color: #1a1a2e;
        background: #fafafa;
        outline: none;
        transition: border-color .18s, box-shadow .18s;
    }

    .reset-input:focus {
        border-color: #0F6E56;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(15,110,86,.12);
    }

    .reset-input::placeholder { color: #d1d5db; }

    .reset-divider {
        height: 1px;
        background: #f0f0f0;
        margin: 1.25rem 0;
    }

    .reset-btn {
        width: 100%;
        padding: .75rem;
        background: #0F6E56;
        color: #E1F5EE;
        border: none;
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        font-weight: 500;
        cursor: pointer;
        letter-spacing: .02em;
        transition: background .18s, transform .12s;
    }

    .reset-btn:hover  { background: #085041; }
    .reset-btn:active { transform: scale(.98); }

    .back-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .35rem;
        margin-top: 1.25rem;
        font-size: .82rem;
        color: #6b7280;
        text-decoration: none;
        transition: color .18s;
    }

    .back-link:hover { color: #0F6E56; }

    .back-link svg {
        width: 13px;
        height: 13px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .alert {
        border-radius: 8px;
        font-size: .85rem;
        border: none;
        padding: .7rem 1rem;
        margin-bottom: 1rem;
    }
</style>

<div class="reset-page">
    <div class="reset-card">

        @if(session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        <div class="reset-icon">
            <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>

        <h1 class="reset-title">Reset password</h1>
        <p class="reset-subtitle">Enter your email and choose a new password to get back into your account.</p>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <label class="field-label" for="email">Email address</label>
            <div class="field-wrap">
                <svg class="field-icon" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <input class="reset-input" id="email" type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required>
            </div>

            <div class="reset-divider"></div>

            <label class="field-label" for="password">New password</label>
            <div class="field-wrap">
                <svg class="field-icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <input class="reset-input" id="password" type="password" name="password" placeholder="Min. 8 characters" required>
            </div>

            <label class="field-label" for="password_confirmation">Confirm new password</label>
            <div class="field-wrap">
                <svg class="field-icon" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                <input class="reset-input" id="password_confirmation" type="password" name="password_confirmation" placeholder="Repeat your password" required>
            </div>

            <button type="submit" class="reset-btn">Reset password</button>
        </form>

        <a href="{{ route('login') }}" class="back-link">
            <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to login
        </a>

    </div>
</div>

@endsection