<x-app-layout>
    {{-- Hero Section --}}
    <header class="bg-[#8B1A1A] hero-slant pt-20 pb-48 px-6 md:px-20 text-white relative">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-12">
            <div class="md:w-1/2">
                <h1 class="text-5xl md:text-7xl font-black leading-[1.1] mb-6 tracking-tight italic">
                    THE PERFECT FIT FOR YOUR PERSONALITY.
                </h1>
                <p class="text-base opacity-80 mb-10 max-w-sm leading-relaxed font-medium">
                    Fashion is personal. Browse our curated vault of footwear and apparel designed to complete your unique identity.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('hn.featured') }}" class="inline-block bg-[#F53003] hover:bg-white hover:text-[#F53003] text-white font-black py-4 px-12 rounded-xl transition-all uppercase tracking-widest text-xs">
                        SHOP THE VAULT
                    </a>
                </div>
            </div>

<div class="md:w-1/2">
    {{-- Update: Replaced the complex overlays with a simple, high-impact image --}}
    <div class="rounded-3xl shadow-2xl overflow-hidden aspect-[4/3] relative group border-4 border-white/10">
        
        {{-- Fixed: Standard Laravel asset path to public/images/shom_img.jpg --}}
        <img src="{{ asset('images/shop_img.jpg') }}" 
             alt="Netkicks Featured Product Vault" 
             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">

    </div>

        </div>
    </header>

    {{-- Featured Products Section --}}
    <section class="max-w-7xl mx-auto px-6 py-20 -mt-12 relative z-10">
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-2xl font-black uppercase tracking-tighter text-gray-900">Featured Products</h2>
            <div class="flex gap-2">
                <button class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition text-gray-400 text-sm">←</button>
                <button class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition text-gray-400 text-sm">→</button>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($products as $product)
            <div class="bg-white border border-gray-100 rounded-2xl p-5 text-center hover:shadow-2xl transition-all duration-300 group">
                
                <div class="h-40 flex items-center justify-center mb-4 bg-gray-50 rounded-xl border border-gray-50 overflow-hidden relative">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500">
                    @else
                        <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                </div>

                <h3 class="font-bold text-[12px] uppercase tracking-tight text-gray-800 truncate">{{ $product->name }}</h3>
                <p class="text-[#F53003] font-black text-[11px] my-1 uppercase">
                    ₱{{ number_format($product->price, 2) }}
                </p>

                <p class="text-[9px] text-gray-400 mb-4 font-bold uppercase tracking-widest">{{ $product->category ?? 'General' }}</p>

                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="bg-gray-100 text-[9px] font-black px-4 py-2.5 rounded-lg uppercase tracking-widest hover:bg-black hover:text-white transition w-full shadow-sm">
                        Add to cart
                    </button>
                </form>
            </div>
            @empty
            <div class="col-span-full py-10 text-center">
                <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Our latest drops are coming soon.</p>
            </div>
            @endforelse
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-black text-white pt-24 pb-12 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-16">
            <div class="flex flex-col items-center md:items-start">
                <h2 class="text-4xl font-black italic mb-2 tracking-tighter">NETKICKS</h2>
                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.3em]">Footwear | Clothes | Apparel</p>
            </div>

            <div>
                <h4 class="font-bold mb-6 uppercase text-[11px] tracking-widest text-white/50">Contact</h4>
                <p class="text-white text-sm mb-1">09867823212</p>
                <p class="text-gray-400 text-sm italic">support@netkicks.com</p>
            </div>

            <div>
                <h4 class="font-bold mb-6 uppercase text-[11px] tracking-widest text-white/50">Shop</h4>
                <ul class="text-gray-400 text-sm space-y-3 font-medium">
                    <li><a href="{{ route('hn.featured') }}" class="hover:text-[#F53003] transition">New & Featured</a></li>
                    <li><a href="{{ route('hn.clothes') }}" class="hover:text-[#F53003] transition">Clothes</a></li>
                    <li><a href="{{ route('hn.shoes') }}" class="hover:text-[#F53003] transition">Shoes</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-6 uppercase text-[11px] tracking-widest text-white/50">Company</h4>
                <ul class="text-gray-400 text-sm space-y-3 font-medium">
                    <li><a href="#" class="hover:text-[#F53003] transition">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-[#F53003] transition">Terms & Conditions</a></li>
                    <li><a href="#" class="hover:text-[#F53003] transition">About Us</a></li>
                </ul>
            </div>
        </div>
    </footer>
</x-app-layout>