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
            <div class="mb-2">
                <span class="text-[10px] font-black text-[#F53003] uppercase tracking-[0.3em] animate-pulse">Clearance Event</span>
                <h2 class="text-4xl font-black uppercase tracking-tighter mb-8 text-[#1b1b18]">Sale Vault</h2>
            </div>

            <nav class="mb-10">
                <ul class="space-y-3 text-[13px] font-bold uppercase tracking-tight text-gray-800">
                    <li><a href="{{ route('hn.clothes') }}" class="hover:text-[#F53003] transition-colors flex justify-between items-center group italic">Clothes <span class="text-gray-300 group-hover:text-[#F53003] transition-transform group-hover:translate-x-1">→</span></a></li>
                    <li><a href="{{ route('hn.shoes') }}" class="hover:text-[#F53003] transition-colors flex justify-between items-center group italic">Shoes <span class="text-gray-300 group-hover:text-[#F53003] transition-transform group-hover:translate-x-1">→</span></a></li>
                    <li><a href="{{ route('hn.crocs') }}" class="hover:text-[#F53003] transition-colors flex justify-between items-center group italic">crocs <span class="text-gray-300 group-hover:text-[#F53003] transition-transform group-hover:translate-x-1">→</span></a></li>
                </ul>
            </nav>

            <hr class="border-gray-100 my-10">

            {{-- Filter Form --}}
            <form action="{{ url()->current() }}" method="GET"
                x-data="{
                    activeFilter: 'gender',
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
                            <div class="py-2 text-[10px] font-black text-center border border-gray-100 rounded-md peer-checked:bg-black peer-checked:text-white hover:border-black uppercase">
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
            </form>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1" x-data="{
            openModal: false,
            buyNow: false,
            selectedProduct: { id: '', name: '', price: 0, original_price: 0, sizes: '', brand: '', stock: 0, image: '' },
            quantity: 1
        }">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
                @forelse ($products as $product)
                <div class="flex flex-col group">
                    {{-- Image Container --}}
                    <div class="relative aspect-[4/5] bg-[#f6f6f6] mb-6 overflow-hidden flex items-center justify-center border border-gray-50 group-hover:bg-[#ebebeb] transition-colors">
                        @if($product->image)
                            <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-4 mix-blend-multiply transition-transform duration-500 group-hover:scale-110">
                        @endif

                        {{-- New Dynamic Sale Badge --}}
                        <div class="absolute top-0 right-0 flex flex-col">
                            <div class="bg-[#F53003] text-white px-3 py-1 text-[9px] font-black uppercase tracking-widest italic">
                                Sale
                            </div>
                            @if($product->discount_percentage)
                            <div class="bg-black text-white px-3 py-1 text-[9px] font-black text-center">
                                -{{ $product->discount_percentage }}%
                            </div>
                            @endif
                        </div>

                        <div class="absolute top-0 left-0 bg-black text-white px-3 py-1 text-[9px] font-black uppercase tracking-widest">
                            {{ $product->brand }}
                        </div>
                    </div>

                    {{-- Product Info --}}
                    <div class="mb-6 text-center">
                        <p class="text-[10px] font-black uppercase tracking-widest text-[#F53003] mb-1">{{ $product->brand }}</p>
                        <h3 class="text-sm font-extrabold uppercase tracking-tight text-black mb-1 line-clamp-1 leading-tight">{{ $product->name }}</h3>

                        {{-- FIXED: Dynamic Pricing logic --}}
                        <div class="flex justify-center gap-2 items-center mb-3">
                            <p class="text-xs font-bold text-black italic">₱{{ number_format($product->price, 2) }}</p>
                            @if($product->original_price)
                            <p class="text-[10px] text-gray-400 line-through">₱{{ number_format($product->original_price, 2) }}</p>
                            @endif
                        </div>

                        <div class="flex flex-wrap justify-center gap-1.5 px-2">
                            @php $productSizes = $product->sizes ? explode(',', $product->sizes) : []; @endphp
                            @foreach($productSizes as $size)
                                <span class="text-[9px] font-black uppercase border border-gray-100 px-2 py-0.5 text-gray-400 group-hover:border-black group-hover:text-black transition-all">
                                    {{ trim($size) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-auto">
                        @auth
                            <div class="flex flex-col gap-2">
                                <button @click="openModal = true; buyNow = false; quantity = 1; selectedProduct = { id: '{{ $product->id }}', name: '{{ addslashes($product->name) }}', price: '{{ $product->price }}', original_price: '{{ $product->original_price }}', sizes: '{{ $product->sizes }}', brand: '{{ $product->brand }}', stock: {{ $product->quantity }}, image: '{{ asset($product->image) }}' }"
                                        class="w-full bg-white text-black text-[9px] font-black uppercase tracking-widest py-4 border border-black hover:bg-black hover:text-white transition-all">
                                    Add to Cart
                                </button>

                                <button @click="openModal = true; buyNow = true; quantity = 1; selectedProduct = { id: '{{ $product->id }}', name: '{{ addslashes($product->name) }}', price: '{{ $product->price }}', original_price: '{{ $product->original_price }}', sizes: '{{ $product->sizes }}', brand: '{{ $product->brand }}', stock: {{ $product->quantity }}, image: '{{ asset($product->image) }}' }"
                                        class="w-full bg-[#F53003] text-white text-[9px] font-black uppercase tracking-widest py-4 border border-[#F53003] hover:bg-black hover:border-black transition-all">
                                    Buy it Now
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
                    <div class="col-span-full py-20 text-center border-2 border-dashed border-gray-100">
                        <p class="text-gray-400 font-black uppercase tracking-[0.3em] text-[10px]">The vault is currently empty.</p>
                    </div>
                @endforelse
            </div>

            {{-- Modal --}}
            <div x-show="openModal" class="fixed inset-0 z-[60] flex items-center justify-center p-6 bg-black/90 backdrop-blur-md" x-cloak>
                <div @click.away="openModal = false" class="bg-white w-full max-w-md p-10 border-t-8 border-[#F53003] shadow-2xl relative max-h-[90vh] overflow-y-auto custom-scrollbar">

                    <div class="relative w-full aspect-square bg-[#f6f6f6] mb-8 overflow-hidden flex items-center justify-center border border-gray-50">
                        <template x-if="selectedProduct.image">
                            <img :src="selectedProduct.image" :alt="selectedProduct.name" class="w-full h-full object-contain p-6 mix-blend-multiply">
                        </template>
                    </div>

                    <div class="text-center mb-8">
                        <p class="text-[#F53003] text-[10px] font-black uppercase tracking-[0.4em] mb-2" x-text="selectedProduct.brand"></p>
                        <h2 class="font-black italic uppercase tracking-tighter text-2xl mb-1 text-black" x-text="selectedProduct.name"></h2>
                        <div class="flex items-center justify-center gap-3">
                            <p class="text-lg font-black text-black" x-text="'₱' + parseFloat(selectedProduct.price).toLocaleString()"></p>
                            <template x-if="selectedProduct.original_price > 0">
                                <p class="text-sm font-bold text-gray-400 line-through" x-text="'₱' + parseFloat(selectedProduct.original_price).toLocaleString()"></p>
                            </template>
                        </div>
                    </div>

                    <form action="{{ route('cart.store') }}" method="POST" class="space-y-8">
                        @csrf
                        <input type="hidden" name="product_id" :value="selectedProduct.id">
                        <input type="hidden" name="action" :value="buyNow ? 'buy_now' : 'add_to_cart'">

                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-black block mb-4">Select Size</label>
                            <div class="grid grid-cols-4 gap-2">
                                <template x-for="size in selectedProduct.sizes ? selectedProduct.sizes.split(',') : []">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="size" :value="size.trim()" class="peer hidden" required>
                                        <div class="border-2 border-gray-100 py-3 text-center text-[11px] font-black uppercase peer-checked:bg-black peer-checked:text-white hover:border-black transition-colors">
                                            <span x-text="size.trim()"></span>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <label class="text-[10px] font-black uppercase tracking-widest text-black">Quantity</label>
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest" x-text="selectedProduct.stock + ' in stock'"></span>
                            </div>
                            <div class="flex items-center border-2 border-black w-fit">
                                <button type="button" @click="if(quantity > 1) quantity--" class="px-5 py-2 font-black text-xl hover:bg-gray-50">-</button>
                                <input type="number" name="quantity" x-model="quantity" readonly class="w-16 text-center font-black text-sm border-none focus:ring-0 bg-transparent">
                                <button type="button" @click="if(quantity < selectedProduct.stock) quantity++" class="px-5 py-2 font-black text-xl hover:bg-gray-50">+</button>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button type="submit"
                                    :disabled="selectedProduct.stock <= 0"
                                    class="text-[10px] font-black uppercase tracking-[0.2em] py-4 border transition-all disabled:opacity-50"
                                    :class="buyNow ? 'bg-[#F53003] border-[#F53003] text-white hover:bg-black hover:border-black' : 'bg-black border-black text-white hover:bg-[#F53003] hover:border-[#F53003]'">
                                <span x-text="buyNow ? 'Proceed to Checkout' : 'Confirm & Add to Bag'"></span>
                            </button>

                            <button type="button" @click="openModal = false" class="text-[9px] font-black uppercase tracking-widest text-gray-400 hover:text-black py-2">
                                Go Back
                            </button>
                        </div>
                    </form>
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
                'Company' => ['Privacy Policy' => 'privacy', 'Terms' => 'terms', 'About Us' => 'about']            ] as $title => $links)
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
