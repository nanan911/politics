<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Figtree', sans-serif;
            /* 移除 overflow: hidden; */
        }

        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            animation: fadeIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .content-container {
            position: relative;
            z-index: 0;
        }

        .content {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20vh;
        }
    </style>
</head>
<body class="antialiased">
    <img src="https://images.pexels.com/photos/596591/pexels-photo-596591.jpeg" alt="Background Image" class="background-image">

    <div class="container login-container">
        <div class="row justify-content-end p-3">
            @if (Route::has('login'))
                <div class="col-sm-auto">
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-outline-secondary">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <div class="container-fluid content-container">
        <div class="row">
            <div class="col-lg-8 mx-auto p-3 content">
                <h2 class="text-center mb-4">Welcome to our Political Analysis Platform</h2>

                <p>
                    Thank you for visiting our platform! We provide in-depth political analysis and insights to keep you informed about current events and political developments.
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
