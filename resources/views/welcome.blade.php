<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                background: #0a0a0a;
                color: #ffffff;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .header {
                padding: 2rem;
                display: flex;
                justify-content: flex-end;
                gap: 1rem;
            }

            .header a {
                color: #a1a09a;
                text-decoration: none;
                padding: 0.5rem 1.5rem;
                border: 1px solid transparent;
                border-radius: 0.25rem;
                transition: all 0.2s;
                font-size: 0.875rem;
            }

            .header a:hover {
                color: #ffffff;
                border-color: #3e3e3a;
            }

            .main {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
            }

            .container {
                max-width: 600px;
                width: 100%;
                text-align: center;
            }

            h1 {
                font-size: 3rem;
                font-weight: 600;
                margin-bottom: 1rem;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .subtitle {
                font-size: 1.25rem;
                color: #a1a09a;
                margin-bottom: 3rem;
                line-height: 1.6;
            }

            .button-group {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn {
                padding: 0.875rem 2rem;
                border-radius: 0.5rem;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.2s;
                border: 1px solid;
                display: inline-block;
            }

            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: #ffffff;
                border-color: transparent;
            }

            .btn-primary:hover {
                opacity: 0.9;
                transform: translateY(-2px);
            }

            .btn-secondary {
                background: transparent;
                color: #eeeeec;
                border-color: #3e3e3a;
            }

            .btn-secondary:hover {
                border-color: #eeeeec;
                background: #1a1a1a;
            }

            .footer {
                padding: 2rem;
                text-align: center;
                color: #666;
                font-size: 0.875rem;
            }

            @media (max-width: 768px) {
                h1 {
                    font-size: 2rem;
                }

                .subtitle {
                    font-size: 1rem;
                }

                .button-group {
                    flex-direction: column;
                }

                .btn {
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        @if (Route::has('login'))
            <header class="header">
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </header>
        @endif

        <main class="main">
            <div class="container">
                <h1>Selamat Datang</h1>
                <p class="subtitle">
                    Sistem Manajemen SDM yang Modern dan Efisien
                </p>
                <div class="button-group">
                    <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Daftar</a>
                </div>
            </div>
        </main>

        <footer class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </footer>
    </body>
</html>