<x-app-layout>
    {{-- Hero Section --}}
    <header class="bg-[#8B1A1A] hero-slant pt-20 pb-48 px-6 md:px-20 text-white relative">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-12">
            <div class="md:w-1/2">
                <h1 class="text-5xl md:text-7xl font-black leading-[1.1] mb-6 tracking-tight italic uppercase">
                    The Perfect Fit For Your <span class="text-[#F53003]">Personality.</span>
                </h1>
                <p class="text-base opacity-80 mb-10 max-w-sm leading-relaxed font-medium">
                    Fashion is personal. Browse our curated vault of footwear and apparel designed to complete your unique identity.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('hn.featured') }}" class="inline-block bg-[#F53003] hover:bg-white hover:text-[#F53003] text-white font-black py-5 px-14 rounded-xl transition-all uppercase tracking-widest text-[11px] shadow-2xl shadow-black/20">
                        Shop The Vault
                    </a>
                </div>
            </div>

            <div class="md:w-1/2 w-full">
                <div class="rounded-[2rem] shadow-2xl overflow-hidden aspect-[4/3] relative group border-4 border-white/10">
                    <img src="{{ asset('images/shop_img.jpg') }}" 
                         alt="Netkicks Featured Product Vault" 
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60 group-hover:opacity-40 transition-opacity"></div>
                </div>
            </div>
        </div>
    </header>

    {{-- Featured Products Section --}}
    <section class="max-w-7xl mx-auto px-6 py-24 -mt-20 relative z-10">
        <div class="flex justify-between items-end mb-12">
            <div>
                <span class="text-[#F53003] text-[10px] font-black uppercase tracking-[0.4em] mb-2 block">Curated Selection</span>
                <h2 class="text-4xl font-black uppercase tracking-tighter text-gray-900 italic">Featured Products</h2>
            </div>
            <div class="flex gap-3">
                <button class="w-12 h-12 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-black hover:text-white transition-all text-gray-400 text-sm">←</button>
                <button class="w-12 h-12 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-black hover:text-white transition-all text-gray-400 text-sm">→</button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-20">
            @forelse ($products->filter(fn($product) => $product->quality) as $product)
                <div class="flex flex-col group cursor-pointer">
                    {{-- Image Container --}}
                    <div class="relative aspect-[4/5] bg-[#f9f9f9] mb-8 overflow-hidden flex items-center justify-center border border-gray-100 group-hover:border-[#F53003]/20 transition-all duration-500">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.png') }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-contain p-8 mix-blend-multiply group-hover:scale-110 transition-transform duration-500">
                        
                        {{-- Hover Overlay --}}
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="bg-black text-white text-[9px] font-black uppercase tracking-[0.3em] py-3 px-6 rounded-lg translate-y-4 group-hover:translate-y-0 transition-transform duration-500">View Product</span>
                        </div>

                        @if($product->quality)
                            <div class="absolute top-4 left-4 bg-[#F53003] text-white px-3 py-1.5 text-[8px] font-black uppercase tracking-[0.2em] italic">
                                {{ $product->quality }}
                            </div>
                        @endif
                    </div>

                    {{-- Product Info --}}
                    <div class="text-center px-4">
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-[#F53003] mb-2">{{ $product->brand }}</p>
                        <h3 class="text-lg font-black uppercase tracking-tighter text-black mb-1 line-clamp-1 leading-none group-hover:text-[#F53003] transition-colors">{{ $product->name }}</h3>
                        <p class="text-sm font-bold text-gray-400 italic mb-5">₱{{ number_format($product->price, 2) }}</p>

                        <div class="flex flex-wrap justify-center gap-2">
                            @php
                                $productSizes = $product->sizes ? explode(',', $product->sizes) : [];
                            @endphp
                            @foreach($productSizes as $size)
                                <span class="text-[8px] font-black uppercase border border-gray-200 px-3 py-1 text-gray-400 group-hover:border-black group-hover:text-black transition-all">
                                    {{ trim($size) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 text-center border-2 border-dashed border-gray-100 rounded-[3rem]">
                    <p class="text-gray-300 font-black uppercase tracking-[0.5em] text-xs">Our latest drops are currently encrypted. Stay tuned.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-black text-white pt-24 pb-12 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-16">
            <div class="flex flex-col items-center md:items-start">
                <h2 class="text-5xl font-black italic mb-2 tracking-tighter text-[#F53003]">NETKICKS</h2>
                <p class="text-[9px] text-gray-600 uppercase font-bold tracking-[0.4em]">Engineered for Identity</p>
            </div>

            <div>
                <h4 class="font-black mb-8 uppercase text-[10px] tracking-[0.3em] text-white/30 italic">Registry</h4>
                <p class="text-white text-sm font-bold mb-1 tracking-tight">0986 782 3212</p>
                <p class="text-gray-500 text-sm italic">support@netkicks.com</p>
            </div>

            <div>
                <h4 class="font-black mb-8 uppercase text-[10px] tracking-[0.3em] text-white/30 italic">Navigation</h4>
                <ul class="text-gray-400 text-sm space-y-4 font-bold uppercase tracking-widest text-[10px]">
                    <li><a href="{{ route('hn.featured') }}" class="hover:text-[#F53003] transition">New & Featured</a></li>
                    <li><a href="{{ route('hn.clothes') }}" class="hover:text-[#F53003] transition">Clothes</a></li>
                    <li><a href="{{ route('hn.shoes') }}" class="hover:text-[#F53003] transition">Shoes</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-black mb-8 uppercase text-[10px] tracking-[0.3em] text-white/30 italic">Legal</h4>
                <ul class="text-gray-400 text-sm space-y-4 font-bold uppercase tracking-widest text-[10px]">
                    <li><a href="#" class="hover:text-[#F53003] transition">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-[#F53003] transition">Terms & Conditions</a></li>
                    <li><a href="#" class="hover:text-[#F53003] transition">About Us</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-24 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[9px] font-bold text-gray-700 uppercase tracking-widest">© 2026 NETKICKS VAULT. ALL RIGHTS RESERVED.</p>
        </div>
    </footer>
</x-app-layout>