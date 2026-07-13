@props([
    'title' => 'ផ្ទាំងគ្រប់គ្រង',
    'navigation' => [],
    'doctor' => [],
])

<!DOCTYPE html>
<html
    lang="km"
    x-data="{
        darkMode: localStorage.getItem('theme')
            ? localStorage.getItem('theme') === 'dark'
            : localStorage.getItem('darkMode') === 'true',
        toggleTheme() {
            this.darkMode = ! this.darkMode;
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            localStorage.setItem('darkMode', this.darkMode);
        }
    }"
    x-bind:class="{ 'dark': darkMode }"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }} | PRUM SANTEPHEAP CLINIC</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Kantumruy+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://unpkg.com/lucide@latest"></script>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        @stack('head')
    </head>
    <body class="min-h-screen bg-[#F8FAFC] font-sans text-slate-950 antialiased dark:bg-slate-950 dark:text-slate-100">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen lg:flex">
            <x-layout.sidebar :items="$navigation" />

            <div class="min-w-0 flex-1 lg:pl-72">
                <x-layout.topbar :doctor="$doctor" />

                <main class="px-4 py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>

                <x-layout.footer />
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>
