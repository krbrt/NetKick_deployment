<!DOCTYPE html>
<html lang="en" class="bg-[#0A0A0A]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NETKICKS | ADMIN PORTAL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased text-white font-sans">
    <div class="flex h-screen overflow-hidden">
<aside class="w-64 bg-[#0A0A0A] min-h-screen border-r border-white/[0.05] flex flex-col font-sans py-8">
    <div class="px-8 mb-12">
        <h1 class="text-white font-black italic text-2xl tracking-tighter uppercase">Netkicks</h1>
        <p class="text-[#F53003] text-[9px] font-black uppercase tracking-[0.3em]">Admin Portal</p>
    </div>

    <nav class="flex-1 px-6">
        {{-- Main Menu Section --}}
<div class="mb-10">
    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 mb-6 px-2">Main Menu</p>

    <div class="space-y-1">
        {{-- Dashboard --}}
        <a href="{{ route('admin.home') }}"
           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-colors group {{ request()->routeIs('admin.home') ? 'text-white' : 'text-gray-500 hover:text-white' }}">
            <div class="{{ request()->routeIs('admin.home') ? 'text-[#F53003]' : 'text-current group-hover:text-[#F53003]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </div>
            <span class="text-[11px] font-black uppercase tracking-widest italic">Dashboard</span>
        </a>

        {{-- Inventory --}}
        <a href="{{ route('admin.inventory') }}"
           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-colors group {{ request()->routeIs('admin.inventory') ? 'text-white' : 'text-gray-500 hover:text-white' }}">
            <div class="{{ request()->routeIs('admin.inventory') ? 'text-[#F53003]' : 'text-current group-hover:text-[#F53003]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <span class="text-[11px] font-black uppercase tracking-widest italic">Inventory</span>
        </a>

        {{-- Add Items --}}
        <a href="{{ route('admin.products.create') }}"
           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-colors group {{ request()->routeIs('admin.products.create') ? 'text-white' : 'text-gray-500 hover:text-white' }}">
            <div class="{{ request()->routeIs('admin.products.create') ? 'text-[#F53003]' : 'text-current group-hover:text-[#F53003]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <span class="text-[11px] font-black uppercase tracking-widest italic">Add Items</span>
        </a>

        {{-- Sales Vault --}}
        <a href="{{ route('admin.sales.index') }}"
           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-colors group {{ request()->routeIs('admin.sales.index') ? 'text-white' : 'text-gray-500 hover:text-white' }}">
            <div class="{{ request()->routeIs('admin.sales.index') ? 'text-[#F53003]' : 'text-current group-hover:text-[#F53003]' }}">
                {{-- Fire Icon for Sales --}}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.99 7.99 0 0120 13a7.99 7.99 0 01-2.343 5.657z"></path>
                </svg>
            </div>
            <span class="text-[11px] font-black uppercase tracking-widest italic">Sales Vault</span>
        </a>

        {{-- Vouchers --}}
        <a href="{{ route('admin.vouchers.index') }}"
           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-colors group {{ request()->routeIs('admin.vouchers.index') ? 'text-white' : 'text-gray-500 hover:text-white' }}">
            <div class="{{ request()->routeIs('admin.vouchers.index') ? 'text-[#F53003]' : 'text-current group-hover:text-[#F53003]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
            </div>
            <span class="text-[11px] font-black uppercase tracking-widest italic">Vouchers</span>
        </a>

        {{-- Sales Report --}}
        <a href="{{ route('admin.reports') }}"
           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-colors group {{ request()->routeIs('admin.reports') ? 'text-white' : 'text-gray-500 hover:text-white' }}">
            <div class="{{ request()->routeIs('admin.reports') ? 'text-[#F53003]' : 'text-current group-hover:text-[#F53003]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-[11px] font-black uppercase tracking-widest italic">Sales Report</span>
        </a>
    </div>
</div>
        {{-- User Control Section --}}
        <div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 mb-6 px-2">User Control</p>

            <a href="{{ route('admin.customers') }}"
               class="flex items-center gap-4 px-3 py-3 rounded-xl transition-colors group {{ request()->routeIs('admin.customers') ? 'text-white' : 'text-gray-500 hover:text-white' }}">
                <div class="{{ request()->routeIs('admin.customers') ? 'text-[#F53003]' : 'text-current group-hover:text-[#F53003]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span class="text-[11px] font-black uppercase tracking-widest italic">Customer List</span>
            </a>
        </div>
    </nav>
</aside>
<div class="flex-1 flex flex-col">
        <main class="flex-1 overflow-y-auto">
            {{-- Header with Profile Dropdown --}}
            <header class="h-24 px-12 border-b border-white/5 flex items-center justify-end">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-4 group focus:outline-none">
                        <div class="text-right hidden sm:block">
                            <p class="text-[10px] font-black uppercase tracking-widest text-white">{{ Auth::user()->name }}</p>
                            <p class="text-[8px] font-bold uppercase tracking-[0.2em] text-[#F53003]">Verified Admin</p>
                        </div>
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center group-hover:border-[#F53003]/50 transition-colors">
                            <span class="text-[10px] font-black uppercase tracking-widest">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         class="absolute right-0 mt-4 w-48 bg-[#0D0D0D] border border-white/5 rounded-xl py-2 shadow-2xl z-[60]">

                        <div class="px-4 py-2 border-b border-white/5 mb-2">
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-500">Account Access</p>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-white hover:bg-white/5 transition-all">
                            Profile Settings
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-[10px] font-black uppercase tracking-widest text-[#F53003] hover:bg-[#F53003]/5 transition-all">
                                System Exit
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="p-12">
                {{ $slot }}
            </div>
        </main>
        </div>
    </div>
</body>
</html>
