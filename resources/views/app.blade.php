<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/animotion.css', 'resources/js/inertia.js'])
    @inertiaHead
</head>
<body class="h-full">
    @inertia
</body>
</html>
