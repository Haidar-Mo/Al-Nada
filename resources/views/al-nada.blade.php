<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Al-Nada Charity</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/al-nada.css') }}">
</head>
<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        <div class="content">
            <div class="title m-b-md">
                <img src="{{ asset('logo/al-nada.png') }}" alt="Al-Nada Logo" class="logo">
                Al-Nada Charity
            </div>
            <div class="links">
                <a href="{{ url('/about') }}">About Us</a>
                <a href="{{ url('/projects') }}">Projects</a>
                <a href="{{ url('/donate') }}">Donate</a>
                <a href="{{ url('/contact') }}">Contact</a>
            </div>
            <div class="m-b-md">
                <p>Al-Nada is dedicated to improving the lives of underprivileged communities through education, healthcare, and sustainable development projects. Join us in making a difference.</p>
            </div>
        </div>
    </div>
</body>
</html>
