<nav class="bg-black text-white sticky top-0 z-50 border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="flex justify-between items-center h-16">

            <div class="flex items-center gap-10">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="group transition-transform hover:scale-105">
                        <img src="{{ asset('images/netkicks.jpg') }}" alt="NETKICKS" class="h-10 w-10 rounded-full border border-gray-700 group-hover:border-[#F53003] transition-colors">
                    </a>
                </div>

                {{-- Main Navigation --}}
                <div class="hidden md:flex gap-8 text-[11px] font-black uppercase tracking-[0.2em]">
                    <a href="{{ route('hn.featured') }}" class="{{ request()->routeIs('hn.featured') ? 'text-[#F53003]' : 'text-gray-400' }} hover:text-white transition-colors">New & Featured</a>
                    <a href="{{ route('hn.clothes') }}" class="{{ request()->routeIs('hn.clothes') ? 'text-[#F53003]' : 'text-gray-400' }} hover:text-white transition-colors">Clothes</a>
                    <a href="{{ route('hn.shoes') }}" class="{{ request()->routeIs('hn.shoes') ? 'text-[#F53003]' : 'text-gray-400' }} hover:text-white transition-colors">Shoes</a>
                    <a href="{{ route('hn.crocs') }}" class="{{ request()->routeIs('hn.crocs') ? 'text-[#F53003]' : 'text-gray-400' }} hover:text-white transition-colors">Crocs</a>
                    <a href="{{ route('hn.sale') }}" class="{{ request()->routeIs('hn.sale') ? 'text-[#F53003]' : 'text-gray-400' }} hover:text-white transition-colors">Sale</a>
                </div>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-4">
                {{-- Search Bar --}}
                <form action="{{ route('hn.featured') }}" method="GET" class="relative hidden lg:block">
                    <input type="text" name="search" placeholder="Search products..."
                           class="bg-[#1a1a1a] text-white text-[10px] rounded-full pl-9 pr-4 py-2 w-48 border border-white/10 focus:border-[#F53003] focus:ring-0 outline-none transition-all placeholder:text-gray-600 font-bold uppercase tracking-wider"
                           value="{{ request('search') }}">
                    <svg class="w-3.5 h-3.5 text-gray-500 absolute left-3.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </form>

                @auth
                    {{-- Cart Button --}}
                    <a href="{{ route('cart.index') }}" class="bg-white text-black px-4 py-2 rounded-full flex items-center gap-2 text-[10px] font-black uppercase hover:bg-[#F53003] hover:text-white transition-all shadow-lg active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="hidden sm:inline">Cart</span>
                        <span class="bg-[#F53003] text-white px-2 py-0.5 rounded-full text-[9px]">
                            {{ session('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </a>

                    {{-- Profile Dropdown (Vanilla JS) --}}
                    <div class="relative" id="profile-dropdown-wrapper">
                        <button id="profile-dropdown-btn"
                                class="flex items-center border border-white/10 rounded-full pl-3 pr-2 py-1 hover:bg-white/5 transition focus:outline-none group">
                            <svg class="w-3.5 h-3.5 text-gray-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="hidden sm:inline text-[10px] font-black uppercase tracking-widest px-2 hover:text-[#F53003] transition-colors max-w-[140px] truncate">
                                {{ Auth::user()->name }}
                            </span>
                            <svg id="profile-dropdown-chevron" class="w-3 h-3 text-gray-600 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div id="profile-dropdown-menu"
                             class="hidden absolute right-0 mt-2 w-52 bg-white text-black shadow-2xl rounded-md z-50 overflow-hidden border border-gray-100"
                             style="transform-origin: top right;">

                            <div class="px-4 py-2 text-[9px] text-gray-400 uppercase font-black tracking-[0.2em] bg-gray-50 border-b border-gray-100">
                                Manage Account
                            </div>

                            @if(Auth::user()->usertype == 'admin')
                                <a href="{{ route('admin.home') }}"
                                   class="block px-4 py-3 text-[11px] font-black uppercase text-[#F53003] hover:bg-red-50 transition-colors">
                                    Admin Dashboard
                                </a>
                            @endif

                            <a href="{{ route('profile.edit') }}"
                               class="block px-4 py-3 text-[11px] font-bold uppercase text-gray-700 hover:bg-gray-100 transition-colors">
                                Profile Settings
                            </a>

                            <div class="border-t border-gray-100"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-3 text-[11px] font-black uppercase text-red-600 hover:bg-red-50 transition-colors">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>

                @else
                    {{-- Guest Links --}}
                    <div class="flex items-center gap-4 ml-2">
                        <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-white transition-colors">Sign In</a>
                        <span class="h-3 w-[1px] bg-white/10"></span>
                        <a href="{{ route('register') }}" class="text-[10px] font-black uppercase tracking-widest text-white hover:text-[#F53003] transition-colors">Join Us</a>
                    </div>
                @endauth

                <button id="mobile-menu-btn"
                        type="button"
                        class="md:hidden inline-flex items-center justify-center p-2 rounded-md border border-white/10 text-gray-300 hover:text-white hover:bg-white/10 transition-colors"
                        aria-controls="mobile-menu"
                        aria-expanded="false">
                    <svg id="mobile-menu-open-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="mobile-menu-close-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="md:hidden hidden border-t border-white/10 bg-black/95">
        <div class="px-4 py-4 space-y-3 text-[11px] font-black uppercase tracking-[0.16em]">
            <a href="{{ route('hn.featured') }}" class="block {{ request()->routeIs('hn.featured') ? 'text-[#F53003]' : 'text-gray-300' }} hover:text-white transition-colors">New & Featured</a>
            <a href="{{ route('hn.clothes') }}" class="block {{ request()->routeIs('hn.clothes') ? 'text-[#F53003]' : 'text-gray-300' }} hover:text-white transition-colors">Clothes</a>
            <a href="{{ route('hn.shoes') }}" class="block {{ request()->routeIs('hn.shoes') ? 'text-[#F53003]' : 'text-gray-300' }} hover:text-white transition-colors">Shoes</a>
            <a href="{{ route('hn.crocs') }}" class="block {{ request()->routeIs('hn.crocs') ? 'text-[#F53003]' : 'text-gray-300' }} hover:text-white transition-colors">Crocs</a>
            <a href="{{ route('hn.sale') }}" class="block {{ request()->routeIs('hn.sale') ? 'text-[#F53003]' : 'text-gray-300' }} hover:text-white transition-colors">Sale</a>
        </div>

        <div class="px-4 pb-4">
            <form action="{{ route('hn.featured') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Search products..."
                       class="w-full bg-[#1a1a1a] text-white text-[10px] rounded-full pl-9 pr-4 py-2.5 border border-white/10 focus:border-[#F53003] focus:ring-0 outline-none transition-all placeholder:text-gray-600 font-bold uppercase tracking-wider"
                       value="{{ request('search') }}">
                <svg class="w-3.5 h-3.5 text-gray-500 absolute left-3.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>
        </div>
    </div>
</nav>

<script>
    (function () {
        const btn     = document.getElementById('profile-dropdown-btn');
        const menu    = document.getElementById('profile-dropdown-menu');
        const chevron = document.getElementById('profile-dropdown-chevron');

        if (!btn || !menu) return;

        function openMenu() {
            menu.classList.remove('hidden');
            menu.style.opacity = '0';
            menu.style.transform = 'scale(0.95)';
            menu.style.transition = 'opacity 100ms ease, transform 100ms ease';
            requestAnimationFrame(() => {
                menu.style.opacity = '1';
                menu.style.transform = 'scale(1)';
            });
            chevron.style.transform = 'rotate(180deg)';
        }

        function closeMenu() {
            menu.style.opacity = '0';
            menu.style.transform = 'scale(0.95)';
            chevron.style.transform = 'rotate(0deg)';
            setTimeout(() => menu.classList.add('hidden'), 100);
        }

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            menu.classList.contains('hidden') ? openMenu() : closeMenu();
        });

        // Close when clicking outside
        document.addEventListener('click', function (e) {
            const wrapper = document.getElementById('profile-dropdown-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                closeMenu();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeMenu();
        });

        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('mobile-menu-open-icon');
        const closeIcon = document.getElementById('mobile-menu-close-icon');

        if (mobileBtn && mobileMenu && openIcon && closeIcon) {
            mobileBtn.addEventListener('click', function () {
                const isHidden = mobileMenu.classList.contains('hidden');
                mobileMenu.classList.toggle('hidden');
                openIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
                mobileBtn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            });
        }
    })();
</script>