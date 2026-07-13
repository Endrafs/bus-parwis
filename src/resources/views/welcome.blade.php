<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHD Trans — Sewa Bus Pariwisata Premium</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300..700&family=JetBrains+Mono:wght@400..600&display=swap" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <script>window.location.href = "{{ route('home') }}";</script>
    <noscript><meta http-equiv="refresh" content="0;url={{ route('home') }}"></noscript>
</body>
</html>