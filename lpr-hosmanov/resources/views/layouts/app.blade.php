<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Авиакомпания' }} — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand bg-dark navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('catalog.index') }}">
                {{ config('app.name') }}
            </a>
            <a class="nav-link text-light" href="{{ route('feedback.form') }}">
                Обратная связь
            </a>
        </div>
    </nav>

    <main class="container flex-grow-1">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>