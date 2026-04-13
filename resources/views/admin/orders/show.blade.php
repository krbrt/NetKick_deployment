<x-admin-layout>
    <x-slot:headerTitle>Order #{{ $order->order_number }}</x-slot>

    <div class="max-w-7xl mx-auto px-6 py-12 space-y-8">
        {{-- Header Navigation --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-6xl font-black italic tracking-tighter uppercase leading-none text-white">
                    Order <span class="text-[#F53003]">#{{ $order->order_number }}</span>
                </h1>
                <div class="flex items-center gap-6 mt-4">
                    <p class="text-[10px] text-gray-500 font-black uppercase tracking-[0.4em] flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#F53003] animate-pulse"></span>
                        Transaction Log • {{ $order->created_at->format('M d, Y') }}
                    </p>
                    {{-- Added Ref No to Header --}}
                    <p class="text-[10px] text-white/40 font-black uppercase tracking-[0.4em] border-l border-white/10 pl-6">
                        Ref: <span class="text-white">{{ $order->reference_number ?? 'N/A' }}</span>
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="bg-[#111] border border-white/5 text-gray-400 hover:text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                ← Back to Manifest
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Customer & Shipping Details --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-[#111] border border-white/5 rounded-[2.5rem] p-10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-10 opacity-5">
                        <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>

                    <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 mb-8 flex items-center gap-3">
                        <div class="w-1 h-3 bg-[#F53003]"></div> Customer Intelligence
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        <div>
                            <p class="text-[9px] font-black uppercase text-[#F53003] tracking-widest mb-2">Recipient</p>
                            <h3 class="text-2xl font-black italic text-white uppercase tracking-tighter">{{ $order->first_name }} {{ $order->last_name }}</h3>
                            <p class="text-gray-400 font-bold text-sm mt-1 tracking-tight">{{ $order->phone }}</p>
                        </div>
                        {{-- Added Reference Number explicitly in Intelligence section --}}
                        <div>
                            <p class="text-[9px] font-black uppercase text-[#F53003] tracking-widest mb-2">Logistics ID</p>
                            <p class="text-white font-mono font-bold text-sm tracking-widest uppercase bg-white/5 px-3 py-1 rounded-lg border border-white/5 inline-block">
                                {{ $order->reference_number ?? 'NO REF' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black uppercase text-[#F53003] tracking-widest mb-2">Shipping Destination</p>
                            <p class="text-white font-bold italic uppercase text-sm leading-relaxed">{{ $order->address }}</p>
                        </div>
                    </div>

                    {{-- Order Items List --}}
                    <div class="mt-12">
                        <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 mb-6">Asset Manifest</h2>
                        <div class="space-y-4">
                            @forelse($order->items as $item)
                                <div class="flex items-center gap-6 p-4 bg-white/[0.02] border border-white/5 rounded-3xl hover:bg-white/[0.04] transition-all group">
                                    <div class="w-20 h-20 bg-black rounded-2xl overflow-hidden border border-white/10 flex-shrink-0">
<img src="{{ $item->product_image ? asset($item->product_image) : 'images/no-image.png' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-white font-black italic uppercase tracking-tighter">{{ $item->product_name }}</h4>
                                        <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mt-1">Size: {{ $item->size ?? 'OS' }} • Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-white font-black italic">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-600 font-black uppercase tracking-widest text-center py-10">Manifest Empty</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Status & Actions --}}
            <div class="space-y-8">
                {{-- Financial Summary Card --}}
                <div class="bg-[#111] border border-white/5 rounded-[2.5rem] p-8">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Total Value</p>
                    <h2 class="text-5xl font-black italic tracking-tighter text-white">₱{{ number_format($order->total_amount, 2) }}</h2>
                    <div class="h-1 w-full bg-white/5 rounded-full mt-6 overflow-hidden">
                        <div class="h-full bg-[#F53003] w-full animate-pulse"></div>
                    </div>
                </div>

                {{-- Status Management Card --}}
                <div class="bg-[#111] border border-white/5 rounded-[2.5rem] p-8">
                    <h2 class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-6">Fulfillment Status</h2>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-4">
                        @csrf @method('PATCH')
                        <select name="status" class="w-full bg-black border border-white/10 rounded-2xl px-5 py-4 text-white text-[11px] font-black uppercase tracking-widest focus:border-[#F53003] focus:ring-0 appearance-none italic cursor-pointer">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>• Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>• Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>• Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>• Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>• Cancelled</option>
                        </select>
                        <button type="submit" class="w-full bg-white text-black hover:bg-[#F53003] hover:text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl shadow-black/50">
                            Update Registry
                        </button>
                    </form>
                </div>

                {{-- Secondary Actions --}}
                <div class="grid grid-cols-1 gap-4">
                    <button onclick="window.print()" class="bg-[#111] border border-white/5 text-white hover:bg-white/10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                        Generate Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Clean Print View */
        @media print {
            body { background: white !important; color: black !important; }
            .no-print, button, a, form { display: none !important; }
            .bg-[#111] { border: 1px solid #eee !important; background: transparent !important; }
            .text-white, .text-gray-400 { color: black !important; }
            .text-[#F53003] { color: #F53003 !important; }
        }
    </style>
</x-admin-layout>