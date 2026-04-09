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


@if(isset($filters))
                @foreach($filters as $key => $data)
                <div class="mb-4">

                    <button type="button" @click="activeFilter = (activeFilter === '{{ $key }}' ? null : '{{ $key }}')"
                            class="w-full flex items-center justify-between py-4 text-[11px] font-black uppercase tracking-widest text-black border-b border-gray-100 hover:text-[#F53003]">
                        {{ $data['label'] }}
                        <svg class="w-4 h-4" :class="activeFilter === '{{ $key }}' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="activeFilter === '{{ $key }}'" class="space-y-2 pb-6 pt-4">
                        @foreach($data['options'] as $option)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="{{ $key }}[]" value="{{ $option }}"
                                   @click.prevent="applyExclusive('{{ $key }}', '{{ $option }}')"
                                   class="w-4 h-4 border-2 border-gray-200 rounded-none checked:bg-black checked:border-black focus:ring-0 cursor-pointer"
                                   {{ in_array($option, request($key, [])) ? 'checked' : '' }}>
                            <span class="text-[12px] font-bold text-gray-500 group-hover:text-black uppercase tracking-tight">
                                {{ $option }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
                @endif

                <div class="mb-4">

                    <button type="button" @click="activeFilter = (activeFilter === 'size' ? null : 'size')"
                            class="w-full flex items-center justify-between py-4 text-[11px] font-black uppercase tracking-widest text-black border-b border-gray-100 hover:text-[#F53003]">
                        Size
                        <svg class="w-4 h-4" :class="activeFilter === 'size' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="activeFilter === 'size'" class="grid grid-cols-4 gap-2 pt-4 pb-6 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                        @php $allSizes = array_merge(['S', 'M', 'L', 'XL'], range(36, 60)); @endphp
                        @foreach($allSizes as $size)
                        <label class="relative cursor-pointer">
                            <input type="checkbox" name="size[]" value="{{ $size }}"
                                   @click.prevent="applyExclusive('size', '{{ $size }}')"
                                   class="peer hidden" {{ in_array((string)$size, request('size', [])) ? 'checked' : '' }}>
                            <div class="py-2 text-[10px] font-bold text-center border border-gray-100 rounded-md peer-checked:bg-black peer-checked:text-white hover:border-black uppercase">
                                {{ $size }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8">
                    @if(request()->anyFilled(['gender', 'category', 'brand', 'price', 'size', 'sale', 'color']))
                        <a href="{{ url()->current() }}" class="block text-center text-[10px] font-black uppercase tracking-widest text-white bg-black py-4 hover:bg-[#F53003]">
                            Clear All Filters
                        </a>
                    @endif
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <main x-data="{
            openModal: false,
            selectedProduct: { id: '', name: '', price: 0, sizes: '', brand: '', stock: 0, image: '' },
            quantity: 1
        }" class="flex-1">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
        @forelse ($products as $product)
        <div class="flex flex-col group">
            {{-- Image Container --}}
            <div class="relative aspect-[4/5] bg-[#f6f6f6] mb-6 overflow-hidden flex items-center justify-center border border-gray-50 group-hover:bg-[#ebebeb] transition-colors">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-4 mix-blend-multiply">
                @endif
                <div class="absolute top-0 left-0 bg-black text-white px-3 py-1 text-[9px] font-black uppercase tracking-widest">
                    {{ $product->brand }}
                </div>
            </div>

            {{-- Product Info --}}
            <div class="mb-6 text-center">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#F53003] mb-1">{{ $product->brand }}</p>
                <h3 class="text-sm font-extrabold uppercase tracking-tight text-black mb-1 line-clamp-1 leading-tight">{{ $product->name }}</h3>
                <p class="text-xs font-bold text-gray-400 italic mb-3">₱{{ number_format($product->price, 2) }}</p>

                {{-- SIZES LISTED ON PAGE --}}
                <div class="flex flex-wrap justify-center gap-1.5 px-2">
                    @php
                        // Convert string "36,37,38" into an array
                        $productSizes = $product->sizes ? explode(',', $product->sizes) : [];
                    @endphp

                    @foreach($productSizes as $size)
                        <span class="text-[9px] font-black uppercase border border-gray-100 px-2 py-0.5 text-gray-400 group-hover:border-black group-hover:text-black transition-all">
                            {{ trim($size) }}
                        </span>
                    @endforeach
                </div>
            </div>

<div class="mt-auto">
    @auth
        <div class="flex flex-col sm:flex-row gap-2">
            {{-- Add to Cart --}}
            <button @click="openModal = true; quantity = 1; selectedProduct = { id: '{{ $product->id }}', name: '{{ addslashes($product->name) }}', price: '{{ $product->price }}', sizes: '{{ $product->sizes }}', brand: '{{ $product->brand }}', stock: {{ $product->quantity }}, image: '{{ asset($product->image) }}' }"
                    class="flex-1 bg-white text-black text-[9px] font-black uppercase tracking-widest py-4 border border-black hover:bg-black hover:text-white transition-all">
                Add to Cart
            </button>

            {{-- Buy Now (Direct to Modal with primary intent) --}}
            <button @click="openModal = true; quantity = 1; selectedProduct = { id: '{{ $product->id }}', name: '{{ addslashes($product->name) }}', price: '{{ $product->price }}', sizes: '{{ $product->sizes }}', brand: '{{ $product->brand }}', stock: {{ $product->quantity }}, image: '{{ asset($product->image) }}' }"
                    class="flex-1 bg-[#F53003] text-white text-[9px] font-black uppercase tracking-widest py-4 border border-[#F53003] hover:bg-black hover:border-black transition-all">
                Buy Now
            </button>
        </div>
    @else
        <a href="{{ route('login') }}" class="block text-center border-2 border-black text-black text-[10px] font-black uppercase tracking-[0.2em] py-4 hover:bg-black hover:text-white transition-all">
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
    </div>

            {{-- Modal --}}
            <div x-show="openModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-6 bg-black/80 backdrop-blur-sm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="openModal = false" x-cloak>
                <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl relative max-h-[90vh] overflow-y-auto">
                    <button @click="openModal = false" class="absolute -top-12 right-0 text-white hover:text-[#F53003] text-xl font-black">
                        ×
                    </button>
                    <div class="p-8">
                        <div class="relative w-full aspect-square bg-gradient-to-br from-gray-50 to-gray-100 mb-8 overflow-hidden rounded-2xl">
                            <img x-show="selectedProduct.image" :src="selectedProduct.image" :alt="selectedProduct.name" class="w-full h-full object-contain p-8">
                        </div>
                        <div class="text-center mb-8">
                            <p class="text-[#F53003] text-[12px] font-black uppercase tracking-[0.4em] mb-4" x-text="selectedProduct.brand"></p>
                            <h2 class="font-black italic uppercase tracking-tighter text-3xl mb-4 text-black" x-text="selectedProduct.name"></h2>
                            <p class="text-2xl font-bold text-gray-700" x-text="'₱' + parseFloat(selectedProduct.price).toLocaleString()"></p>
                        </div>
                        <form action="{{ route('cart.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="product_id" x-model="selectedProduct.id">
                            <div>
                                <label class="text-xs font-black uppercase tracking-wider text-gray-700 mb-4 block">Select Size</label>
                                <div class="grid grid-cols-5 gap-2">
                                    <template x-for="size in selectedProduct.sizes.split(',')">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="size" :value="size.trim()" class="peer sr-only" required>
                                            <div class="border-2 border-gray-300 py-3 px-2 text-center text-sm font-black uppercase rounded-xl peer-checked:bg-black peer-checked:text-white peer-checked:border-black hover:border-gray-600 transition-all">
                                                <span x-text="size.trim()"></span>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mb-6">
                                <label class="text-xs font-black uppercase tracking-wider text-gray-700">Quantity</label>
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider" x-text="'Stock: ' + selectedProduct.stock"></span>
                            </div>
                            <div class="flex items-center border-2 border-gray-300 rounded-xl p-2">
                                <button type="button" @click="quantity = Math.max(1, quantity - 1)" class="px-4 py-2 font-black text-lg hover:bg-gray-100 rounded-lg transition-colors">-</button>
                                <input type="number" name="quantity" x-model.number="quantity" min="1" :max="selectedProduct.stock" class="w-20 text-center font-black text-xl border-none focus:ring-0 bg-transparent" readonly>
                                <button type="button" @click="quantity = Math.min(selectedProduct.stock, quantity + 1)" class="px-4 py-2 font-black text-lg hover:bg-gray-100 rounded-lg transition-colors">+</button>
                            </div>
                            <button type="submit" :disabled="selectedProduct.stock === 0" class="w-full bg-black text-white py-4 rounded-2xl font-black uppercase text-lg tracking-[0.1em] hover:bg-[#F53003] transition-all shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

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

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #000; }
    </style>
</x-app-layout>
