<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background: #0a0a0a;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
        .footer {
            padding: 2rem;
            text-align: center;
            color: #666;
            font-size: 0.875rem;
        }
        @media (max-width: 768px) {
            h1 { font-size: 2rem; }
            .subtitle { font-size: 1rem; }
        }
    </style>
</head>
<body>
    <main class="main">
        <div class="container">
            <h1>Selamat Datang</h1>
            <p class="subtitle">Sistem Manajemen SDM yang Modern dan Efisien</p>
        </div>
    </main>
    <footer class="footer">
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </footer>
</body>
</html>
