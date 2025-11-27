@extends('layouts.landing')

@section('title', 'About Us - NexStack')

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

<section style="padding: 50px; max-width: 1200px; margin: 0 auto;">
    <h1 class="text-center mb-5" style="font-size: 48px; font-weight: bold;">ABOUT US</h1>
    
    <div class="card mb-5">
        <div class="card-header">
            <h2>Company Overview</h2>
        </div>
        <div class="card-body">
            <p>NexStack is a leading provider of inventory management solutions. We help businesses streamline their operations, reduce costs, and improve efficiency through our comprehensive inventory management system.</p>
            <p>Our platform offers real-time tracking, automated reporting, and intuitive interfaces designed to make inventory management simple and effective for businesses of all sizes.</p>
        </div>
    </div>

    <div class="card mb-5">
        <div class="card-header">
            <h2>Our Team</h2>
        </div>
        <div class="card-body text-center">
            <!-- Replace the team cards with a single team image. -->
            <!-- Place the provided team image at public/images/team.png (or team.jpg).
                 If you already attached an image, copy it into that path so the site will display it. -->
            <img src="{{ asset('images/Team.png') }}" alt="NexStock Team" class="team-image img-fluid rounded shadow-lg">
        </div>
    </div>

    <div class="card mb-5" id="contact">
        <div class="card-header">
            <h2>Get In Touch</h2>
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="contact_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="contact_name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="contact_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="contact_email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Send Message</button>
            </form>
        </div>
    </div>
</section>
@endsection

