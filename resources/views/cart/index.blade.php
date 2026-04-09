<x-app-layout>
    <div class="p-6 md:p-12 bg-white min-h-screen text-black">

        {{-- Status Notifications --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed top-24 right-10 z-[100] bg-black text-white px-6 py-4 rounded-xl border-l-4 border-[#F53003] shadow-2xl flex items-center gap-4 transition-all">
                <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex items-center justify-between mb-10 max-w-6xl mx-auto">
            <div class="flex items-center gap-4">
                <div class="bg-[#F53003] p-2.5 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-black italic tracking-tighter uppercase text-[#1b1b18]">Vault</h1>
                    <p class="text-[9px] text-[#F53003] font-bold uppercase tracking-[0.2em]">Secure your selection</p>
                </div>
            </div>
            <div class="text-right">
                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Total Items</span>
                <p class="text-xl font-black italic">{{ count($cartItems) }}</p>
            </div>
        </div>

        <div class="space-y-4 max-w-6xl mx-auto">
            @php $total = 0; @endphp

            @forelse($cartItems as $id => $item)
                @php
                    // Array syntax fix: Accessing data via keys
                    $price = $item['product']['price'] ?? $item['price'] ?? 0;
                    $quantity = $item['quantity'] ?? 1;
                    $itemTotal = $price * $quantity;
                    $total += $itemTotal;
                @endphp

                <div class="bg-[#1b1b18] p-5 rounded-[1.5rem] border border-white/5 flex flex-col md:flex-row items-center gap-6 relative overflow-hidden shadow-2xl transition-all hover:border-[#F53003]/30">

                    {{-- Product Image --}}
                    <div class="w-24 h-24 bg-[#f9f9f9] rounded-[1rem] flex-shrink-0 flex items-center justify-center border border-white/5 overflow-hidden">
                        @php $image = $item['product']['image'] ?? $item['image'] ?? null; @endphp
                        @if($image)
                            <img src="{{ asset('storage/' . $image) }}" class="w-3/4 h-3/4 object-contain">
                        @else
                            <div class="text-[8px] font-black uppercase text-black/20 italic text-center px-2">No Image</div>
                        @endif
                    </div>

                    {{-- Product Details --}}
                    <div class="flex-1 text-center md:text-left">
                        <h4 class="text-lg font-black italic uppercase tracking-tighter text-white">
                            {{ $item['product']['name'] ?? $item['name'] ?? 'Unknown Item' }}
                        </h4>
                        <div class="flex items-center gap-3 justify-center md:justify-start mt-1">
                            <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">
                                {{ $item['product']['category'] ?? $item['category'] ?? 'General Apparel' }}
                            </span>
                            <span class="text-[10px] bg-[#F53003] text-white px-2 py-0.5 rounded font-black italic uppercase">
                                SIZE: {{ $item['size'] ?? 'N/A' }}
                            </span>
                        </div>
                        <p class="text-lg font-black italic text-[#F53003] mt-2 tracking-tighter">
                            ₱ {{ number_format($price, 2) }}
                        </p>
                    </div>

                    {{-- Quantity & Actions --}}
                    <div class="flex items-center gap-3">
                        <div class="flex items-center bg-[#2a2a2a] rounded-full p-1 border border-white/5">
                            {{-- Decrease --}}
                            <form action="{{ route('cart.update') }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="hidden" name="quantity" value="{{ $quantity - 1 }}">
                                <button type="submit" class="w-8 h-8 flex items-center justify-center text-xs font-black text-gray-500 hover:text-[#F53003] transition" {{ $quantity <= 1 ? 'disabled' : '' }}>—</button>
                            </form>

                            <span class="px-4 font-black text-xs italic text-white">{{ $quantity }}</span>

                            {{-- Increase --}}
                            <form action="{{ route('cart.update') }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="hidden" name="quantity" value="{{ $quantity + 1 }}">
                                <button type="submit" class="w-8 h-8 flex items-center justify-center text-xs font-black text-gray-500 hover:text-[#F53003] transition">+</button>
                            </form>
                        </div>

                        <form action="{{ route('cart.destroy', $id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-[#2a2a2a] text-red-500 px-5 py-2 rounded-full border border-white/5 text-[9px] font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition">Remove</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-gray-50 p-24 rounded-[2.5rem] border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-center">
                    <p class="text-gray-400 font-black uppercase tracking-[0.3em] text-xs">Your vault is empty</p>
                    <a href="{{ route('hn.index') }}" class="mt-8 bg-black text-white px-10 py-4 rounded-full font-black uppercase italic text-[10px] tracking-widest hover:bg-[#F53003] transition-all">Start Shopping</a>
                </div>
            @endforelse
        </div>

        @if(count($cartItems) > 0)
        <div class="mt-12 max-w-6xl mx-auto flex flex-col items-end border-t border-gray-200 pt-8">
            <div class="text-right mb-6">
                <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mb-1">Subtotal Amount</p>
                <h3 class="text-4xl font-black italic tracking-tighter uppercase text-gray-900">₱ {{ number_format($total, 2) }}</h3>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('hn.index') }}" class="px-8 py-3.5 rounded-full border border-gray-200 font-black uppercase text-[9px] tracking-widest text-gray-900 hover:bg-gray-50 transition">Back to Shop</a>
                <a href="{{ route('checkout.index') }}" class="px-10 py-3.5 bg-[#F53003] text-white rounded-full font-black uppercase text-[10px] tracking-widest shadow-lg shadow-red-200 hover:scale-105 transition-all active:scale-95 text-center">
                    Proceed to Checkout
                </a>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
