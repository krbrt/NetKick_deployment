<x-admin-layout>
    <div class="p-8 md:p-12 bg-[#0A0A0A] min-h-screen text-white font-sans selection:bg-[#F53003] selection:text-white">
        <div class="max-w-7xl mx-auto">

            {{-- Header Section --}}
            <div class="flex flex-col mb-12 border-b border-white/5 pb-10">
                <h1 class="text-6xl font-black uppercase tracking-tighter leading-none italic">
                    Inventory <span class="text-[#F53003]">Archive.</span>
                </h1>
                <div class="flex items-center gap-4 mt-4">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.3em]">
                        System Index // {{ $products->total() }} Units Logged
                    </p>
                    <span class="h-px w-12 bg-white/10"></span>
                    <p class="text-[10px] text-green-500 font-bold uppercase tracking-[0.3em]">
                        Sector Status: Operational
                    </p>
                </div>
            </div>

            {{-- Search --}}
            <form action="{{ route('admin.inventory') }}" method="GET" class="mb-10">
                <div class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="SEARCH ARCHIVE..."
                        class="w-full bg-[#111] border border-white/5 rounded-xl py-5 pl-8 pr-20 text-[11px] font-bold uppercase tracking-widest focus:ring-0 focus:border-[#F53003]/50 transition-all placeholder-gray-700 text-white">
                    <button type="submit" class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-[#F53003] transition-colors">
                        Filter
                    </button>
                </div>
            </form>

            {{-- Archive Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[9px] font-black uppercase text-gray-600 tracking-[0.2em] border-b border-white/5">
                            <th class="pb-6 pr-4">Image</th>
                            <th class="pb-6 px-4">Product Name & Brand</th>
                            <th class="pb-6 px-4 text-center">Type</th>
                            <th class="pb-6 px-4 text-center">Color</th>
                            <th class="pb-6 px-4 text-center">Sizes</th>
                            <th class="pb-6 px-4 text-center">Gender</th>
                            <th class="pb-6 px-4 text-center text-[#F53003]">Stock</th>
                            <th class="pb-6 px-4 text-center">Price</th>
                            <th class="pb-6 pl-4 text-right">Overrides</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.03]">
                        @forelse($products as $product)
                        <tr class="group hover:bg-white/[0.01] transition-all">
                            {{-- Image --}}
                            <td class="py-8 pr-4">
                                <div class="w-16 h-16 bg-[#111] rounded-xl overflow-hidden flex-shrink-0 flex items-center justify-center p-2 border border-white/5 group-hover:border-[#F53003]/30 transition-colors">
<img src="{{ $product->image_url }}" class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                </div>
                            </td>

                            {{-- Name & Brand --}}
                            <td class="py-8 px-4">
                                <p class="text-[8px] text-[#F53003] font-bold uppercase tracking-widest mb-1 italic">{{ $product->brand }}</p>
                                <h4 class="font-black uppercase text-sm tracking-tight text-white leading-none group-hover:text-white transition-colors">
                                    {{ $product->name }}
                                </h4>
                                <p class="text-[9px] text-gray-600 mt-2 font-bold uppercase tracking-widest">REF: {{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </td>

                            {{-- Type --}}
                            <td class="py-8 px-4 text-center">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                    {{ $product->category }}
                                </span>
                            </td>

                            {{-- Color --}}
                            <td class="py-8 px-4 text-center">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                    {{ $product->color ?? 'N/A' }}
                                </span>
                            </td>

                            {{-- Sizes --}}
                            <td class="py-8 px-4 text-center">
                                @php
                                    $sizeStockMap = $product->size_stock_map;
                                    $sizeStockText = collect($sizeStockMap)->map(function ($qty, $size) {
                                        return $qty === null ? $size : ($size . '(' . $qty . ')');
                                    })->implode(', ');
                                @endphp
                                <span class="text-[10px] font-black italic text-white bg-white/5 px-2 py-1 rounded">
                                    {{ $sizeStockText !== '' ? $sizeStockText : 'N/A' }}
                                </span>
                            </td>

                            {{-- Gender --}}
                            <td class="py-8 px-4 text-center">
                                <span class="text-[9px] font-black uppercase tracking-tighter px-2 py-1 border border-white/10 text-gray-500">
                                    {{ $product->gender ?? 'Unisex' }}
                                </span>
                            </td>

                            {{-- Stock Count --}}
                            <td class="py-8 px-4 text-center">
                                <span class="text-sm font-black italic {{ $product->quantity < 5 ? 'text-[#F53003] animate-pulse' : 'text-white' }}">
                                    {{ str_pad($product->quantity, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            {{-- Price --}}
                            <td class="py-8 px-4 text-center">
                                <span class="text-sm font-black italic tracking-tighter">₱{{ number_format($product->price, 2) }}</span>
                            </td>

                            {{-- Actions --}}
                            <td class="py-8 pl-4 text-right">
                                <div class="flex justify-end items-center gap-4">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-white/5 hover:bg-white hover:text-black p-2.5 rounded-lg transition-all" title="Edit Asset">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                        @if($product->quantity > 0)
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('CRITICAL: EJECT ASSET?')">
                                            @csrf @method('DELETE')
                                            <button class="bg-white/5 hover:bg-[#F53003] text-white p-2.5 rounded-lg transition-all" title="Delete Asset">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                        @else
                                        <span class="text-gray-500 p-2.5" title="Zero stock - cannot delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </span>
                                        @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="py-32 text-center text-[10px] font-black uppercase tracking-[0.5em] text-gray-700 italic">
                                No Assets Authenticated
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-12 flex justify-center vault-pagination">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <style>
        .vault-pagination nav { @apply flex gap-1; }
        .vault-pagination span, .vault-pagination a {
            @apply px-5 py-3 text-[10px] font-black bg-[#111] border border-white/5 rounded-xl transition-all uppercase italic text-gray-500;
        }
        .vault-pagination .active span { @apply bg-[#F53003] text-white border-[#F53003]; }
        .vault-pagination a:hover { @apply border-white/20 text-white; }
    </style>
</x-admin-layout>
