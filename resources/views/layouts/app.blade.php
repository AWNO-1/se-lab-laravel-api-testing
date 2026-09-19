<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'مساحة المهام') }}</title>

        {{-- خط عربي واضح ومناسب للواجهات الحديثة. --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=noto-kufi-arabic:400,500,600,700&display=swap" rel="stylesheet" />

        {{-- تحميل ملفات Tailwind وJavaScript من خلال Vite. --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="relative min-h-screen overflow-hidden bg-slate-50">
            <div class="pointer-events-none absolute inset-x-0 top-0 -z-0 h-96 bg-gradient-to-b from-indigo-100/70 via-violet-50/40 to-transparent"></div>

            @include('layouts.navigation')

            {{-- عنوان الصفحة وأزرارها السياقية. --}}
            @isset($header)
                <header class="relative z-10 border-b border-white/70 bg-white/70 backdrop-blur-xl">
                    <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- المحتوى الرئيسي لكل صفحة. --}}
            <main class="relative z-10">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
