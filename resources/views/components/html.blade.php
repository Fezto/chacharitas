<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
<!-- Mensajes Flash -->
@if(session('success'))
    <x-alert type="alert-success" class="rounded-none">
        {{ session('success') }}
    </x-alert>
@endif

@if(session('error'))
    <x-alert type="alert-error" class="rounded-none">
        {{ session('error') }}
    </x-alert>
@endif

@if(session('info'))
    <x-alert type="alert-info" class="rounded-none">
        {{ session('info') }}
    </x-alert>
@endif

@if(session('warning'))
    <x-alert type="alert-warning" class="rounded-none">
        {{ session('warning') }}
    </x-alert>
@endif

<!-- Contenido de las vistas -->
{{ $slot }}

@filamentScripts
@vite('resources/js/app.js')
</body>
</html>
