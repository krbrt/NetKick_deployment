<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NETKICKS - Footwear & Apparel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
        .hero-slant { clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-white text-[#1b1b18] antialiased">

    @include('layouts.navigation')

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
                <div class="rounded-3xl shadow-2xl overflow-hidden aspect-[4/3] relative group border-4 border-white/10">
                    <img src="{{ asset('images/shop_img.jpg') }}"
                         alt="Netkicks Featured Product Vault"
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                </div>
            </div>
        </div>
    </header>

    {{-- Featured Section --}}
<section class="max-w-7xl mx-auto px-6 py-20 -mt-12 relative z-10">
    <div class="flex justify-between items-end mb-12">
        <div>
            <p class="text-[#F53003] text-[10px] font-black uppercase tracking-[0.4em] mb-2">selection</p>
            <h2 class="text-4xl font-black uppercase tracking-tighter">Featured Products</h2>
        </div>
        <a href="{{ route('hn.featured') }}" class="text-[11px] font-black uppercase tracking-widest border-b-2 border-[#F53003] pb-1 hover:text-[#F53003] transition-colors">View All</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @forelse ($products->filter(fn($product) => $product->quality) as $product)
            {{-- Added x-data to manage the state for each product card --}}
            @php
                $sizes = collect(explode(',', (string) $product->sizes))
                    ->map(fn($size) => trim($size))
                    ->filter()
                    ->values()
                    ->all();
                $defaultSize = count($sizes) > 0 ? $sizes[0] : 'Standard';
            @endphp
            <div class="flex flex-col group" x-data="{ selectedSize: '{{ $defaultSize }}' }">
                {{-- Image Container --}}
                <div class="relative aspect-[4/5] bg-[#f6f6f6] mb-6 overflow-hidden flex items-center justify-center border border-gray-50 group-hover:bg-[#ebebeb] transition-colors">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-4 mix-blend-multiply">
                    
                    @if($product->quality)
                        <div class="absolute top-0 left-0 bg-[#F53003] text-white px-3 py-1 text-[9px] font-black uppercase tracking-widest">
                            {{ $product->quality }}
                        </div>
                    @endif
                </div>

                {{-- Product Info --}}
                <div class="mb-6 text-center">
                    <p class="text-[10px] font-black uppercase tracking-widest text-[#F53003] mb-1">{{ $product->brand }}</p>
                    <h3 class="text-sm font-extrabold uppercase tracking-tight text-black mb-1 line-clamp-1 leading-tight">{{ $product->name }}</h3>
                    
                    {{-- Price Display --}}
                    <div class="flex justify-center gap-2 items-center mb-3">
                        <span class="text-lg font-black text-[#F53003]">₱{{ number_format($product->price, 2) }}</span>
                        @if($product->original_price)
                            <span class="text-sm font-normal text-gray-400 line-through">₱{{ number_format($product->original_price, 2) }}</span>
                        @endif
                    </div>

                    {{-- Size Selector --}}
                    <div class="flex flex-wrap justify-center gap-1.5 px-2">
                        @forelse($sizes as $size)
                            <button type="button"
                                    @click="selectedSize = '{{ $size }}'"
                                    :class="selectedSize === '{{ $size }}' ? 'bg-black text-white border-black' : 'border-gray-200 text-gray-400 hover:border-black hover:text-black'"
                                    class="text-[9px] font-black uppercase border px-3 py-1 transition-all outline-none">
                                {{ $size }}
                            </button>
                        @empty
                            <span class="text-[8px] font-black uppercase border border-gray-200 px-3 py-1 text-gray-400">
                                Standard
                            </span>
                        @endforelse
                    </div>
                </div>

                @auth
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        {{-- Added hidden input to bind the Alpine.js selectedSize to the form submission --}}
                        <input type="hidden" name="size" :value="selectedSize">

<button type="submit"
        class="w-full bg-black text-white text-[10px] font-black py-3 rounded-lg uppercase tracking-widest hover:bg-[#F53003] transition-colors">
    Add To Cart
</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="inline-block bg-gray-100 text-gray-500 text-[10px] font-black py-3 rounded-lg uppercase tracking-widest hover:bg-black hover:text-white transition w-full text-center">
                        Sign in to Buy
                    </a>
                @endauth

            </div>
        @empty
            <div class="col-span-full text-center py-20 border-2 border-dashed border-gray-100 rounded-3xl">
                <p class="text-gray-300 italic font-black uppercase tracking-[0.3em] text-sm">The vault is currently empty.</p>
            </div>
        @endforelse
    </div>
</section>

    {{-- Footer --}}
    <footer class="bg-black text-white pt-24 pb-12 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-16">
            <div class="flex flex-col items-center md:items-start">
                <h2 class="text-4xl font-black italic mb-2 tracking-tighter text-[#F53003]">NETKICKS</h2>
                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.3em]">Footwear | Clothes | Apparel</p>
            </div>

            @php
                $footerLinks = [
                    'Contact' => [
                        'Facebook' => 'https://www.facebook.com/profile.php?id=61555962290158',
                        'Email'    => 'mailto:support@netkicks.com',
                    ],
                    'Shop' => [
                        'New & Featured' => 'hn.featured',
                        'Clothes'        => 'hn.clothes',
                        'Shoes'          => 'hn.shoes',
                        'Crocs'          => 'hn.crocs',
                        'Sale'           => 'hn.sale',
                    ],
                    'Company' => [
                        'Privacy Policy' => 'privacy',
                        'Terms'          => 'terms',
                        'About Us'       => 'about',
                    ],
                ];
            @endphp

            @foreach($footerLinks as $title => $links)
            <div>
                <h4 class="font-bold mb-6 uppercase text-[11px] tracking-widest text-white/50">{{ $title }}</h4>
                <ul class="text-gray-400 text-xs space-y-3 font-bold uppercase tracking-wider">
                    @foreach($links as $label => $url)
                        <li>
                            <a href="{{ Route::has($url) ? route($url) : $url }}"
                               class="hover:text-[#F53003] transition-colors">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <div class="max-w-7xl mx-auto mt-20 pt-8 border-t border-white/5 text-center">
            <p class="text-[9px] text-gray-600 uppercase font-black tracking-widest">© 2026 NETKICKS GLOBAL. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>