@extends('layouts.landing')

@section('title', 'NexStack - Inventory Management System')

@section('content')
<header class="landing-header">
    <div>
        @if(Auth::check())
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/Logo.png') }}" alt="NexStock" class="site-logo">
            </a>
        @else
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/Logo.png') }}" alt="NexStock" class="site-logo">
            </a>
        @endif
    </div>
    <nav class="landing-nav">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('about') }}">About</a>
        <a href="#contact">Contact</a>
        <a href="{{ route('login') }}" class="btn btn-success">Get Started</a>
    </nav>
</header>

<section class="landing-hero">
    <div class="hero-content">
        <h1>INVENTORY MANAGEMENT SYSTEM</h1>
        <p>Streamline your inventory management with our comprehensive solution. Track products, manage suppliers, and generate reports all in one place.</p>
        <a href="{{ route('login') }}" class="btn btn-success btn-lg">LEARN MORE</a>
    </div>
    <div class="hero-image">
        <i class="bi bi-boxes" style="font-size: 200px; opacity: 0.5;"></i>
    </div>
</section>
@endsection

