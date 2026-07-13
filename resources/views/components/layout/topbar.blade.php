@props(['doctor' => []])

<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-900/85">
    <div class="flex h-16 items-center gap-3 px-4 sm:px-6 lg:px-8">
        <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 lg:hidden" x-on:click="sidebarOpen = true" aria-label="បើកម៉ឺនុយ">
            <i data-lucide="menu" class="h-5 w-5"></i>
        </button>

        <div class="hidden min-w-0 flex-1 md:block">
            <label class="relative block max-w-md">
                <span class="sr-only">ស្វែងរក</span>
                <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                <input type="search" placeholder="ស្វែងរកអ្នកជំងឺ ការណាត់ជួប ឬរបាយការណ៍..." class="h-10 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm outline-none transition focus:border-[#2F6F3E] focus:bg-white focus:ring-4 focus:ring-[#2F6F3E]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900">
            </label>
        </div>

        <div class="ml-auto flex items-center gap-2">
            <button type="button" class="flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800" aria-label="ជំនួយ">
                <i data-lucide="circle-help" class="h-4 w-4"></i>
            </button>
            <button type="button" class="relative flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800" aria-label="សារ">
                <i data-lucide="message-square" class="h-4 w-4"></i>
                <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-[#16A34A] ring-2 ring-white dark:ring-slate-900"></span>
            </button>
            <button type="button" class="relative flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800" aria-label="ការជូនដំណឹង">
                <i data-lucide="bell" class="h-4 w-4"></i>
                <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-[#EF4444] ring-2 ring-white dark:ring-slate-900"></span>
            </button>
            <button
                type="button"
                class="flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800"
                x-on:click="toggleTheme()"
                x-bind:aria-label="darkMode ? 'ប្ដូរទៅ Light mode' : 'ប្ដូរទៅ Dark mode'"
            >
                <i x-show="! darkMode" data-lucide="moon" class="h-4 w-4"></i>
                <i x-cloak x-show="darkMode" data-lucide="sun" class="h-4 w-4"></i>
            </button>

            <div x-data="{ open: false }" class="relative">
                <button type="button" class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white py-1 pl-1 pr-3 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:hover:bg-slate-800" x-on:click="open = !open" x-on:keydown.escape.window="open = false" aria-haspopup="menu">
                    <img src="{{ $doctor['avatar'] ?? '' }}" alt="{{ $doctor['name'] ?? 'Doctor' }}" class="h-9 w-9 rounded-xl object-cover">
                    <span class="hidden text-left sm:block">
                        <span class="block text-sm font-bold text-slate-900 dark:text-white">{{ $doctor['name'] ?? 'វេជ្ជបណ្ឌិត' }}</span>
                        <span class="block text-xs text-slate-500 dark:text-slate-400">{{ $doctor['department'] ?? 'ផ្នែកព្យាបាល' }}</span>
                    </span>
                    <i data-lucide="chevron-down" class="hidden h-4 w-4 text-slate-400 sm:block"></i>
                </button>

                <div x-cloak x-show="open" x-transition x-on:click.outside="open = false" class="absolute right-0 mt-2 w-56 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-slate-900" role="menu">
                    <a href="{{ route('profile') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        <i data-lucide="user-round" class="h-4 w-4"></i>
                        ប្រវត្តិរូប
                    </a>
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        <i data-lucide="settings" class="h-4 w-4"></i>
                        ការកំណត់
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
