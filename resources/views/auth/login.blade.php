@extends('layouts.landing')

@section('title', 'Login - NexStack')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-image">
            <i class="bi bi-boxes" style="font-size: 300px; opacity: 0.5;"></i>
        </div>
        <div class="auth-form-container">
            <h2>Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Username / Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <a href="#" class="text-white" style="text-decoration: none;">Forgot Password?</a>
                </div>
                <button type="submit" class="btn btn-success w-100 mb-3">Login</button>
                <div class="text-center">
                    <span class="text-white">Don't have an account? </span>
                    <a href="{{ route('register') }}" class="text-white" style="text-decoration: underline;">Register</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

