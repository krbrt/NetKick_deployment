<x-admin-layout>
    <div class="p-8 bg-[#0f0f0f] min-h-screen text-[#e5e5e5] font-sans">
        
        {{-- Header Section --}}
        <div class="flex justify-between items-end mb-10">
            <div>
                <h1 class="text-6xl font-black uppercase italic tracking-tighter text-white leading-none">
                    Sale <span class="text-[#F53003]">Vault</span>
                </h1>
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.4em] mt-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#F53003] animate-pulse"></span>
                    Active Promotions Manifest
                </p>
            </div>
            
            <a href="{{ route('admin.inventory') }}" class="bg-[#111] border border-white/5 text-gray-400 hover:text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                ← Back to Inventory
            </a>
        </div>

        {{-- Quick Deploy Section --}}
        <div class="bg-[#111] border border-white/5 rounded-[2.5rem] p-8 mb-10 relative overflow-hidden">
            <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 mb-6 flex items-center gap-3">
                <div class="w-1 h-3 bg-[#F53003]"></div> Quick Deploy to Vault
            </h2>
            
            <form action="{{ route('admin.sales.quick-add') }}" method="POST" class="flex flex-col md:flex-row gap-4">
                @csrf
                <div class="flex-1">
                    <select name="product_id" class="w-full bg-black border border-white/10 rounded-2xl px-6 py-4 text-white text-[11px] font-black uppercase tracking-widest focus:border-[#F53003] focus:ring-0 appearance-none italic cursor-pointer">
                        <option value="">Select Asset to Push...</option>
                        @foreach($otherProducts as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} — MSRP: ₱{{ number_format($product->price) }}</option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="bg-white text-black hover:bg-[#F53003] hover:text-white px-10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl shadow-black/50">
                    Push to Sale
                </button>
            </form>
        </div>

        {{-- Sales Table --}}
        <div class="bg-[#111] border border-white/5 rounded-[2.5rem] overflow-hidden shadow-2xl">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-white/5 bg-black/40">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 italic">Asset Profile</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 italic text-center">Stock</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 italic text-center">Valuation</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 italic text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.02]">
                    @forelse($salesItems as $item)
                    <tr class="group hover:bg-white/[0.02] transition-all">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-6">
                                <div class="relative w-16 h-16 bg-black rounded-2xl overflow-hidden border border-white/10 flex-shrink-0">
                                    <img src="{{ asset($item->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @php
                                        $discount = $item->original_price > 0 ? round((($item->original_price - $item->price) / $item->original_price) * 100) : 0;
                                    @endphp
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    <span class="absolute bottom-1 right-1 text-[#F53003] text-[8px] font-black italic">-{{ $discount }}%</span>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-[#F53003] uppercase tracking-widest mb-1">{{ $item->brand }}</p>
                                    <h4 class="text-white font-black italic uppercase tracking-tighter">{{ $item->name }}</h4>
                                    <p class="text-[9px] text-gray-600 font-bold uppercase tracking-widest mt-1 italic">VLT-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <span class="text-[10px] font-black px-4 py-2 bg-white/[0.02] border border-white/5 rounded-xl text-gray-400">
                                {{ $item->quantity }} UNITS
                            </span>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <div class="flex flex-col">
                                <span class="text-white font-black italic tracking-tighter">₱{{ number_format($item->price, 2) }}</span>
                                <span class="text-[9px] text-gray-600 line-through font-bold tracking-widest">₱{{ number_format($item->original_price, 2) }}</span>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <form action="{{ route('admin.sales.toggle', $item->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="text-[9px] font-black uppercase tracking-widest bg-white/5 hover:bg-red-500/10 hover:text-red-500 px-6 py-3 rounded-xl border border-white/5 transition-all">
                                    Pull Asset
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-32 text-center">
                            <p class="text-gray-600 font-black uppercase tracking-[0.5em] text-[10px]">Vault Manifest Empty</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($salesItems->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $salesItems->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>