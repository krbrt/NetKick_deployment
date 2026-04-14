<x-app-layout>
    {{-- Success Toast Notification --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-10 right-10 z-[100] bg-black text-white px-6 py-4 flex items-center gap-4 border-l-4 border-[#F53003] shadow-2xl">
            <div class="flex items-center justify-center bg-[#F53003] rounded-full p-1">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <p class="text-[11px] font-black uppercase tracking-widest">{{ session('success') }}</p>
        </div>
    @endif

    <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-12 px-6 py-16 min-h-screen bg-white">
        {{-- Sidebar --}}
        <aside class="w-full md:w-64 flex-shrink-0">
            {{-- Header --}}
            <div class="mb-8">
                <p class="text-[#F53003] text-[10px] font-black uppercase tracking-widest">Footwear</p>
                <h2 class="text-4xl font-black uppercase tracking-tighter">Crocs</h2>
            </div>

            {{-- Main Category Navigation --}}
            <nav class="space-y-4 mb-10 text-[13px] font-bold uppercase tracking-tight text-gray-800">
                {{-- Updated to use array syntax category[] for compatibility with applyFilters --}}
                <a href="?category[]=Clogs" class="hover:text-[#F53003] transition-colors flex justify-between group">Classic Clogs</a>
                <a href="?category[]=Sandals" class="hover:text-[#F53003] transition-colors flex justify-between group">Sandals & Slides</a>
                <a href="?category[]=Echo" class="hover:text-[#F53003] transition-colors flex justify-between group">Echo Collection</a>
                <a href="?category[]=Platforms" class="hover:text-[#F53003] transition-colors flex justify-between group">Platforms & Wedge</a>
            </nav>

            {{-- Filters Section --}}
            <div x-data="{
                activeFilter: null,
                applyExclusive(name, value) {
                    const url = new URL(window.location.href);
                    url.searchParams.set(name + '[]', value);
                    window.location.href = url.href;
                }
            }">


            <form action="{{ url()->current() }}" method="GET" x-data="{ activeFilter: null }">
                @php $filters = $filters ?? []; @endphp

                @foreach($filters as $key => $data)
                <div class="mb-4">
                    <button type="button" @click="activeFilter = (activeFilter === '{{ $key }}' ? null : '{{ $key }}')"
                            class="w-full flex items-center justify-between py-4 text-[11px] font-black uppercase tracking-widest text-black border-b border-gray-100 hover:text-[#F53003]">
                        {{ $data['label'] }}
                        <svg class="w-4 h-4 transition-transform" :class="activeFilter === '{{ $key }}' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="activeFilter === '{{ $key }}'" class="space-y-2 pb-6 pt-4">
                        @foreach($data['options'] as $option)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="{{ $key }}[]" value="{{ $option }}"
                                   class="w-4 h-4 border-2 border-gray-200 rounded-none checked:bg-black checked:border-black focus:ring-0 cursor-pointer"
                                   {{ in_array($option, (array)request($key, [])) ? 'checked' : '' }}>
                            <span class="text-[12px] font-bold text-gray-500 group-hover:text-black uppercase tracking-tight">
                                {{ $option }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="mb-4">
                    <button type="button" @click="activeFilter = (activeFilter === 'size' ? null : 'size')"
                            class="w-full flex items-center justify-between py-4 text-[11px] font-black uppercase tracking-widest text-black border-b border-gray-100 hover:text-[#F53003]">
                        Size
                        <svg class="w-4 h-4 transition-transform" :class="activeFilter === 'size' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="activeFilter === 'size'" class="grid grid-cols-4 gap-2 pt-4 pb-6 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                        @php $allSizes = array_merge(['S', 'M', 'L', 'XL'], range(36, 60)); @endphp
                        @foreach($allSizes as $size)
                        <label class="relative cursor-pointer">
                            <input type="checkbox" name="size[]" value="{{ $size }}"
                                   class="peer hidden" {{ in_array((string)$size, (array)request('size', [])) ? 'checked' : '' }}>
                            <div class="py-2 text-[10px] font-black text-center border border-gray-100 rounded-md peer-checked:bg-black peer-checked:text-white hover:border-black uppercase transition-all">
                                {{ $size }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit" class="block w-full text-center text-[10px] font-black uppercase tracking-widest text-white bg-black py-4 hover:bg-[#F53003] border-none cursor-pointer transition-colors">
                        Apply Filters
                    </button>
                    @if(request()->hasAny(['gender', 'category', 'brand', 'color', 'price', 'size']))
                        <a href="{{ url()->current() }}" class="block text-center text-[10px] font-black uppercase tracking-widest text-white bg-[#F53003] py-4 mt-2 hover:bg-black transition-colors">
                            Clear All Filters
                        </a>
                    @endif
                </div>
            </form>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
                @forelse ($products->filter(fn($product) => $product->quality) as $product)

                @php
                    $imageUrl = $product->image_url;
                    $productSizes = collect(explode(',', (string) $product->sizes))
                        ->map(fn($size) => trim($size))
                        ->filter()
                        ->values()
                        ->all();
                    $defaultSize = count($productSizes) > 0 ? $productSizes[0] : 'Standard';
                @endphp

                <div class="flex flex-col group h-full">

                    {{-- Image --}}
                    <div class="relative aspect-[4/5] bg-[#f6f6f6] mb-6 overflow-hidden flex items-center justify-center border border-gray-50 group-hover:bg-[#ebebeb] transition-colors">
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                             class="w-full h-full object-contain p-4 mix-blend-multiply" loading="lazy">
                        @if($product->quality)
                            <div class="absolute top-0 left-0 bg-[#F53003] text-white px-3 py-1 text-[9px] font-black uppercase tracking-widest">
                                {{ $product->quality }}
                            </div>
                        @endif
                    </div>

                    {{-- Product Info & Interactive Sizes --}}
                    <div class="mb-6 text-center">
                        <p class="text-[10px] font-black uppercase tracking-widest text-[#F53003] mb-1">{{ $product->brand }}</p>
                        <h3 class="text-sm font-extrabold uppercase tracking-tight text-black mb-1 line-clamp-1 leading-tight">{{ $product->name }}</h3>
                        <p class="text-xs font-bold text-gray-400 italic mb-4">₱{{ number_format($product->price, 2) }}</p>

                        {{-- Selectable Sizes --}}
                        <div class="flex flex-wrap justify-center gap-1.5 px-2">
                            @forelse($productSizes as $size)
                                <button type="button" 
                                        data-size-button
                                        onclick="setProductSize({{ $product->id }}, @js($size), this)"
                                        class="text-[9px] font-black uppercase border px-3 py-1 transition-all outline-none {{ $loop->first ? 'bg-black text-white border-black' : 'border-gray-200 text-gray-400 hover:border-black hover:text-black' }}">
                                    {{ $size }}
                                </button>
                            @empty
                                <button type="button"
                                        data-size-button
                                        onclick="setProductSize({{ $product->id }}, 'Standard', this)"
                                        class="text-[9px] font-black uppercase border px-3 py-1 transition-all outline-none bg-black text-white border-black">
                                    Standard
                                </button>
                            @endforelse
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-auto">
                        @auth
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" id="selected-size-{{ $product->id }}" name="size" value="{{ $defaultSize }}">

<div class="flex flex-col sm:flex-row gap-2">
    <button type="submit"
        class="w-full bg-black text-white text-[10px] font-black py-3 rounded-lg uppercase tracking-widest hover:bg-[#F53003] transition-colors">
        Add to Cart
    </button>
    
    <button type="submit" formaction="{{ route('cart.buyNow') }}"
         class="w-full block text-center bg-black text-white text-[10px] font-black py-3 rounded-lg uppercase tracking-widest hover:bg-[#F53003] transition-colors">
        Buy Now
    </button>
</div>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                               class="block text-center flex items-center justify-center h-12 border-2 border-black text-black text-[10px] font-black uppercase tracking-[0.2em] mt-4 hover:bg-black hover:text-white transition-all">
                                Sign in to Shop
                            </a>
                        @endauth
                    </div>

                </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <p class="text-gray-400 font-black uppercase tracking-[0.3em] text-[10px]">No items found.</p>
                    </div>
                @endforelse

                @if($products->hasPages())
                    <div class="flex justify-center mt-20 col-span-full">
                        {{ $products->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </main>
    </div>
    

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

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #000; }
    </style>
    <script>
        function setProductSize(productId, size, buttonEl) {
            const input = document.getElementById(`selected-size-${productId}`);
            if (input) input.value = size;

            const container = buttonEl.parentElement;
            if (!container) return;

            container.querySelectorAll('[data-size-button]').forEach((btn) => {
                btn.classList.remove('bg-black', 'text-white', 'border-black');
                btn.classList.add('border-gray-200', 'text-gray-400', 'hover:border-black', 'hover:text-black');
            });

            buttonEl.classList.remove('border-gray-200', 'text-gray-400', 'hover:border-black', 'hover:text-black');
            buttonEl.classList.add('bg-black', 'text-white', 'border-black');
        }
    </script>
</x-app-layout>
