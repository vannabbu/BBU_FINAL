<!DOCTYPE html>
<html lang="km">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'PRUM SANTEPHEAP CLINIC')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-emerald-50 font-sans text-gray-950">
        @php
            $navigation = [
                ['label' => 'ផ្ទាំងគ្រប់គ្រង', 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard')],
                ['label' => 'ពេទ្យឯកទេស', 'href' => route('specialties.index'), 'active' => request()->routeIs('specialties.*', 'departments.*')],
                ['label' => 'វេជ្ជបណ្ឌិត', 'href' => route('doctors.consultation'), 'active' => request()->routeIs('doctors.*')],
                ['label' => 'អ្នកជំងឺ', 'href' => route('patients.update'), 'active' => request()->routeIs('patients.*')],
                ['label' => 'វិភាគសុខភាព', 'href' => route('health-analysis.index'), 'active' => request()->routeIs('health-analysis.*')],
                ['label' => 'ការណាត់ជួប', 'href' => route('appointments.index'), 'active' => request()->routeIs('appointments.*')],
                ['label' => 'មន្ទីរពិសោធន៍', 'href' => route('diagnosis-reports.index'), 'active' => request()->routeIs('diagnosis-reports.*')],
                ['label' => 'បន្ទប់', 'href' => route('rooms.index'), 'active' => request()->routeIs('rooms.*')],
                ['label' => 'ឃ្លាំងឱសថ', 'href' => route('medicines.index'), 'active' => request()->routeIs('medicines.*')],
                ['label' => 'វិក្កយបត្រ', 'href' => route('invoices.index'), 'active' => request()->routeIs('invoices.*')],
                ['label' => 'ការកំណត់', 'href' => route('settings.index'), 'active' => request()->routeIs('settings.*')],
            ];
        @endphp

        <div class="min-h-screen lg:flex">
            <aside class="bg-emerald-950 text-white lg:fixed lg:inset-y-0 lg:flex lg:w-72 lg:flex-col">
                <div class="flex items-center gap-3 border-b border-emerald-800 px-5 py-5">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-emerald-500 text-lg font-bold text-emerald-950">ព</div>
                    <div>
                        <p class="text-base font-bold leading-6">គ្លីនិក ព្រហ្ម សន្តិភាព</p>
                        <p class="text-xs text-emerald-200">PRUM SANTEPHEAP CLINIC</p>
                    </div>
                </div>

                <nav class="flex-1 space-y-1 px-3 py-4">
                    @foreach ($navigation as $item)
                        <a
                            href="{{ $item['href'] }}"
                            class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $item['active'] ? 'bg-emerald-500 text-emerald-950' : 'text-emerald-50 hover:bg-emerald-900' }}"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="border-t border-emerald-800 px-5 py-4 text-sm text-emerald-100">
                    <p class="font-semibold">ប្រព័ន្ធគ្រប់គ្រងគ្លីនិក</p>
                    <p class="mt-1 text-xs text-emerald-300">ត្រៀមសម្រាប់សិទ្ធិអ្នកប្រើ និង ២ ជំហាន</p>
                </div>
            </aside>

            <main class="min-h-screen flex-1 lg:pl-72">
                <header class="border-b border-emerald-100 bg-white/90 px-5 py-4 backdrop-blur">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-emerald-700">សូមស្វាគមន៍</p>
                            <h1 class="text-2xl font-bold text-emerald-950">@yield('page-title', 'ផ្ទាំងគ្រប់គ្រង')</h1>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ route('profile') }}" class="rounded-lg bg-[#2f6f3e] px-3 py-2 text-sm font-semibold text-white hover:bg-[#285f35]">
                                ប្រវត្តិរូប
                            </a>
                            <div class="flex items-center gap-2 rounded-lg border border-emerald-100 bg-emerald-50 px-3 py-2 text-sm text-emerald-900">
                                <span class="font-semibold">ស្ថានភាព</span>
                                <span>ដំណើរការ</span>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="px-5 py-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </body>
</html>
