<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Welcome to Grace Evangelical Church — a community of faith, hope, and love.">
    <meta name="keywords" content="Grace Evangelical Church, church, faith, community, sermons, books">
    <title>Welcome | Grace Evangelical Church</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .navbar-custom {
            background-color: rgba(0, 0, 0, 0.6);
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
        }
        .btn-custom {
            border-radius: 30px;
            background: #e8b84b;
            color: #1a1a2e;
            padding: 10px 24px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-custom:hover {
            background: #fff;
            color: #1a1a2e;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(232, 184, 75, 0.4);
        }
        .hero-text {
            text-align: center;
            margin-top: 50px;
            padding: 0 20px;
        }
        .hero-text h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        .hero-text .highlight {
            color: #e8b84b;
        }
        .hero-text p {
            font-size: 1.15rem;
            margin-bottom: 35px;
            color: rgba(255, 255, 255, 0.8);
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ url('/') }}">
            <strong>Grace Evangelical Church</strong>
        </a>
        <div class="d-flex">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-custom me-2">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-custom me-2">
                        Log In
                    </a>
                @endauth
            @endif
        </div>
    </div>
</nav>

<div class="hero-text">
    <h1>Welcome to <span class="highlight">Grace Evangelical Church</span></h1>
    <p>A community of faith, hope, and love — growing together in the Word of God.</p>
    <div>
        <a href="{{ route('login') }}" class="btn btn-custom me-2">Get Started</a>
    </div>
</div>

<!-- Add Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
