<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'DevThèque') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center py-10 px-4 bg-gradient-to-br from-blue-50 via-slate-50 to-white">
            <div class="flex flex-col items-center mb-8">
                <a href="/" class="mb-3">
                    <x-application-logo class="w-14 h-14" />
                </a>
                <h1 class="text-2xl font-bold text-brand-navy">DevThèque</h1>
                <p class="text-slate-500 text-sm mt-1">Le sanctuaire des connaissances techniques.</p>
            </div>

            <div class="w-full sm:max-w-md">
                {{ $slot }}
            </div>

            <div class="flex gap-6 text-xs text-slate-400 mt-8">
                <a href="{{ route('articles.index') }}" class="hover:text-slate-600">Aide</a>
                <a href="{{ route('articles.index') }}" class="hover:text-slate-600">Confidentialité</a>
                <a href="{{ route('articles.index') }}" class="hover:text-slate-600">Conditions</a>
            </div>
        </div>
    </body>
</html>