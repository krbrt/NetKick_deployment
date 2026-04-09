<!DOCTYPE html>
<html lang="en" class="bg-[#0A0A0A]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VAULT // ADMIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .nav-link-active { color: #F53003; border-right: 3px solid #F53003; background: linear-gradient(90deg, transparent, rgba(245,48,3,0.05)); }
    </style>
</head>
<body class="antialiased text-white">

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-24 md:w-64 border-r border-white/5 bg-[#0A0A0A] sticky top-0 h-screen flex flex-col items-center md:items-stretch py-10 z-50">
            {{-- Logo --}}
            <div class="px-8 mb-16">
                <div class="w-10 h-10 bg-[#F53003] rounded-xl flex items-center justify-center shadow-[0_0_20px_rgba(245,48,3,0.3)]">
                    <span class="font-black italic text-xl">V</span>
                </div>
            </div>

            {{-- Navigation Links --}}
            <nav class="flex-1 space-y-2">
                <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="hidden md:block ml-4 text-[10px] font-black uppercase tracking-[0.2em]">Overview</span>
                </x-nav-link>

                <x-nav-link href="{{ route('admin.inventory') }}" :active="request()->routeIs('admin.inventory*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span class="hidden md:block ml-4 text-[10px] font-black uppercase tracking-[0.2em]">Inventory</span>
                </x-nav-link>

                <x-nav-link href="#">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="hidden md:block ml-4 text-[10px] font-black uppercase tracking-[0.2em]">Customers</span>
                </x-nav-link>
            </nav>

            {{-- Bottom Actions --}}
            <div class="px-8 mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex items-center text-gray-600 hover:text-[#F53003] transition-colors group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="hidden md:block ml-4 text-[10px] font-black uppercase tracking-[0.2em]">System Exit</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
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

</body>
</html>