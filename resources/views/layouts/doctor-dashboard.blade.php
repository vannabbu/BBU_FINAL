<!DOCTYPE html>
<html lang="km">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'ផ្ទាំងគ្រប់គ្រង | PRUM SANTEPHEAP CLINIC')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-[#f5f7f6] font-sans text-slate-900 antialiased">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen lg:flex">
            <x-hospital-sidebar :items="$navigation" />

            <div class="min-w-0 flex-1 lg:pl-72">
                <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
                    <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                        <button
                            type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-slate-600 lg:hidden"
                            x-on:click="sidebarOpen = true"
                            aria-label="បើកម៉ឺនុយ"
                        >
                            <span class="text-xl leading-none">☰</span>
                        </button>

                        <div>
                            <p class="text-xs font-semibold text-[#2f6f3e]">PRUM SANTEPHEAP CLINIC</p>
                            <h1 class="text-lg font-bold text-slate-950">@yield('page-title', 'ផ្ទាំងគ្រប់គ្រង')</h1>
                        </div>

                        <div class="ml-auto flex items-center gap-2 sm:gap-3">
                            <button type="button" class="relative flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm">
                                <span class="text-lg">🔔</span>
                                <span class="absolute right-2 top-2 h-2.5 w-2.5 rounded-full bg-[#2f6f3e] ring-2 ring-white"></span>
                            </button>
                            <button type="button" class="hidden h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm sm:flex">
                                <span class="text-lg">✉</span>
                            </button>
                            <a href="{{ route('profile') }}" class="flex items-center gap-3 rounded-full border border-slate-200 bg-white py-1 pl-1 pr-3 shadow-sm transition hover:border-[#2f6f3e]/30 hover:bg-[#2f6f3e]/5">
                                <img src="{{ $doctor['avatar'] }}" alt="{{ $doctor['name'] }}" class="h-9 w-9 rounded-full object-cover">
                                <div class="hidden text-left sm:block">
                                    <p class="text-sm font-bold text-slate-900">{{ $doctor['name'] }}</p>
                                    <p class="text-xs text-slate-500">{{ $doctor['specialty'] }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </header>

                <main class="px-4 py-6 sm:px-6 lg:px-8">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
