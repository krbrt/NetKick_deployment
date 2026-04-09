<x-app-layout>
    <div class="min-h-screen bg-[#0A0A0A] text-white font-sans selection:bg-[#F53003]">

        {{-- Hero --}}
        <section class="pt-32 pb-20 px-6 border-b border-white/5">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-6xl md:text-8xl font-black italic uppercase tracking-tighter mb-4">
                    About <span class="text-[#F53003]">Netkicks</span>
                </h1>
                <p class="text-xs text-gray-500 uppercase tracking-[0.5em] mb-8">Santa Maria • Bulacan • Global</p>
                <p class="text-lg text-gray-400 font-medium leading-relaxed italic">
                    Bringing world-class footwear and apparel closer to the local community.
                </p>
            </div>
        </section>

        {{-- Mission & Image --}}
        <section class="py-24 px-6 max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <h2 class="text-4xl font-black italic uppercase tracking-tight">Rooted in <br>Bulacan Culture.</h2>
                    <p class="text-gray-400 leading-relaxed">
                        Netkicks Footwear and Apparel is a proudly local store based in <span class="text-white">Santa Maria, Bulacan</span>.
                        Founded in 2026, we curate trend-forward pieces and premium brands for the modern sneakerhead.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl border border-white/5">
                            <div class="text-[#F53003] font-black italic text-xl">01</div>
                            <div class="text-sm font-bold uppercase tracking-widest">100% Authentic Assets</div>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl border border-white/5">
                            <div class="text-[#F53003] font-black italic text-xl">02</div>
                            <div class="text-sm font-bold uppercase tracking-widest">Fast Local Delivery</div>
                        </div>
                    </div>
                </div>

                <div class="relative aspect-square rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
                    <img src="{{ asset('images/netkicks.jpg') }}" alt="Store" class="w-full h-full object-cover grayscale">
                </div>
            </div>
        </section>

        {{-- Footer --}}
    <footer class="bg-black text-white pt-24 pb-12 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-16">
            <div class="flex flex-col items-center md:items-start">
                <h2 class="text-4xl font-black italic mb-2 tracking-tighter text-[#F53003]">NETKICKS</h2>
                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.3em]">Footwear | Clothes | Apparel</p>
            </div>

            @foreach([
'Contact' => ['https://www.facebook.com/profile.php?id=61555962290158', 'support@netkicks.com'],
                'Shop' => ['New & Featured' => 'hn.featured', 'Clothes' => 'hn.clothes', 'Shoes' => 'hn.shoes', 'Crocs' => 'hn.crocs', 'Sale' => 'hn.sale'],
                'Company' => ['Privacy Policy' => 'privacy', 'Terms' => 'terms', 'About Us' => 'about']
            ] as $title => $links)
            <div>
                <h4 class="font-bold mb-6 uppercase text-[11px] tracking-widest text-white/50">{{ $title }}</h4>
                <ul class="text-gray-400 text-xs space-y-3 font-bold uppercase tracking-wider">
                    @foreach($links as $label => $url)
                        <li><a href="{{ Route::has($url) ? route($url) : $url }}" class="hover:text-[#F53003] transition">{{ is_numeric($label) ? $url : $label }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <div class="max-w-7xl mx-auto mt-20 pt-8 border-t border-white/5 text-center">
            <p class="text-[9px] text-gray-600 uppercase font-black tracking-widest">© 2026 NETKICKS GLOBAL. All Rights Reserved.</p>
        </div>
    </footer>
    </div>
</x-app-layout>
