@extends('layouts.landing')

@section('title', 'Register - NexStack')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-image">
            <i class="bi bi-boxes" style="font-size: 300px; opacity: 0.5;"></i>
        </div>
        <div class="auth-form-container">
            <h2>Register</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
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
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-success w-100 mb-3">Register</button>
                <div class="text-center">
                    <span class="text-white">Already have an account? </span>
                    <a href="{{ route('login') }}" class="text-white" style="text-decoration: underline;">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

