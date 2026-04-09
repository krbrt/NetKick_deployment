<x-admin-layout>
    <div class="p-8 bg-[#0f0f0f] min-h-screen text-[#e5e5e5] font-sans">
        
        {{-- Header Section --}}
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl font-black uppercase italic tracking-tighter text-white">
                    Sale <span class="text-[#F53003]">Vault</span>
                </h1>
                <p class="text-[10px] font-bold text-[#F53003] uppercase tracking-[0.3em] mt-1">
                    Inventory Management
                </p>
            </div>
            
            <a href="{{ route('admin.inventory') }}" class="text-[11px] font-bold text-gray-400 uppercase tracking-widest hover:text-white transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Inventory
            </a>
        </div>

        {{-- Quick Add Section (Styled like the "Add New Product" card) --}}
        <div class="bg-[#1a1a1a] rounded-[2rem] p-8 border border-white/5 mb-10 shadow-2xl">
            <h2 class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 mb-6">Quick Deploy to Vault</h2>
            
            <form action="{{ route('admin.sales.quick-add') }}" method="POST" class="flex flex-col md:flex-row gap-4">
                @csrf
                <div class="flex-1">
                    <select name="product_id" class="w-full bg-[#121212] text-xs font-bold uppercase tracking-widest text-white border border-white/10 rounded-2xl py-5 px-6 focus:ring-2 focus:ring-[#F53003] focus:border-transparent transition-all appearance-none cursor-pointer">
                        <option value="">Select Product Model to Push...</option>
                        @foreach($otherProducts as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (₱{{ number_format($product->price) }})</option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="bg-[#F53003] text-white text-[11px] font-black uppercase tracking-[0.2em] px-10 py-5 rounded-2xl hover:brightness-110 transition-all shadow-[0_10px_20px_rgba(245,48,3,0.2)]">
                    Push to Sale
                </button>
            </form>
        </div>

        {{-- Sales Table --}}
        <div class="bg-[#1a1a1a] rounded-[2rem] border border-white/5 overflow-hidden shadow-2xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-black/20">
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 italic">Product Model</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 italic">Vault Stock</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 italic">Sale Price</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 italic text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.03]">
                    @forelse($salesItems as $item)
                    <tr class="group hover:bg-white/[0.02] transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 rounded-2xl bg-[#121212] border border-white/5 p-3 group-hover:border-[#F53003]/30 transition-colors">
                                    <img src="{{ asset($item->image) }}" class="w-full h-full object-contain filter drop-shadow-lg">
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-[#F53003] uppercase tracking-tighter">{{ $item->brand }}</p>
                                    <p class="text-sm font-black text-white uppercase tracking-tighter group-hover:text-[#F53003] transition-colors">{{ $item->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-black px-4 py-2 bg-[#121212] rounded-xl border border-white/5 group-hover:border-[#F53003]/20 transition-all">{{ $item->quantity }} PCS</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-white italic">₱{{ number_format($item->price, 2) }}</span>
                                <span class="text-[10px] text-gray-600 line-through font-bold tracking-widest mt-0.5">₱{{ number_format($item->original_price, 2) }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <form action="{{ route('admin.sales.toggle', $item->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button class="text-[10px] font-black uppercase tracking-[0.2em] bg-white/5 hover:bg-red-500/10 hover:text-red-600 px-6 py-3 rounded-xl border border-white/5 transition-all">
                                    Pull from Vault
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-40 text-center">
                            <p class="text-gray-600 font-black uppercase tracking-[0.5em] text-xs">No Items in the Sale Vault</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-12 flex justify-center">
            {{ $salesItems->links() }}
        </div>
    </div>
</x-admin-layout>