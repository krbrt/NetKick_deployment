<div class="bg-[#1b1b18] rounded-[2.5rem] overflow-hidden border border-white/5 shadow-2xl">
    {{-- Table Header / Title --}}
    <div class="p-8 pb-4 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-8 h-[2px] bg-[#F53003]"></span>
                <p class="text-[9px] text-[#F53003] font-black uppercase tracking-[0.3em]">Logistics Overview</p>
            </div>
            <h2 class="text-3xl font-black italic text-white uppercase tracking-tighter">Incoming Orders</h2>
        </div>

        {{-- Quick Stats Badge --}}
        <div class="bg-white/5 px-4 py-2 rounded-xl border border-white/5">
            <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">Active Orders</p>
            {{-- Updated to use $orders->total() if paginated, or count() --}}
            <p class="text-white font-black italic text-right">{{ $orders instanceof \Illuminate\Pagination\LengthAwarePaginator ? $orders->total() : $orders->count() }}</p>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="overflow-x-auto px-4 pb-4">
        <table class="w-full text-left border-separate border-spacing-y-3">
            <thead>
                <tr class="text-[10px] uppercase font-black tracking-[0.2em] text-gray-500 px-4">
                    <th class="py-4 pl-6">Order ID</th>
                    <th class="py-4">Customer</th>
                    <th class="py-4 text-center">Total Amount</th>
                    <th class="py-4 text-center">Status</th>
                    <th class="py-4 pr-6 text-right">Management</th>
                </tr>
            </thead>
            <tbody class="text-xs font-bold uppercase tracking-wider">
                @forelse($orders as $order)
                <tr class="group bg-white/[0.02] hover:bg-white/[0.05] transition-all duration-300">
                    {{-- Order # --}}
                    <td class="py-5 pl-6 rounded-l-2xl border-y border-l border-white/5 group-hover:border-[#F53003]/30">
                        <span class="text-[#F53003] font-black italic">#{{ $order->order_number }}</span>
                        <p class="text-[8px] text-gray-600 mt-0.5 tracking-normal">{{ $order->created_at->diffForHumans() }}</p>
                    </td>

                    {{-- Customer Info --}}
                    <td class="py-5 border-y border-white/5 group-hover:border-[#F53003]/30">
                        <div class="flex flex-col">
                            <span class="text-white">{{ $order->first_name }} {{ $order->last_name }}</span>
                            <span class="text-[9px] text-gray-500 lowercase tracking-normal">{{ $order->phone }}</span>
                        </div>
                    </td>

                    {{-- Total Amount --}}
                    <td class="py-5 text-center border-y border-white/5 group-hover:border-[#F53003]/30">
                        <span class="text-white font-black italic tracking-tighter text-sm">₱{{ number_format($order->total_amount, 2) }}</span>
                    </td>

                    {{-- Status Badge --}}
                    <td class="py-5 text-center border-y border-white/5 group-hover:border-[#F53003]/30">
                        <span class="px-4 py-1.5 rounded-full text-[9px] font-black italic border
                            {{ $order->status === 'pending' ? 'bg-orange-500/10 text-orange-500 border-orange-500/20' : '' }}
                            {{ $order->status === 'processing' ? 'bg-blue-500/10 text-blue-500 border-blue-500/20' : '' }}
                            {{ $order->status === 'shipped' ? 'bg-purple-500/10 text-purple-500 border-purple-500/20' : '' }}
                            {{ $order->status === 'delivered' ? 'bg-green-500/10 text-green-500 border-green-500/20' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-500/10 text-red-500 border-red-500/20' : '' }}">
                            {{ $order->status }}
                        </span>
                    </td>

                    {{-- Action Button --}}
                    <td class="py-5 pr-6 text-right rounded-r-2xl border-y border-r border-white/5 group-hover:border-[#F53003]/30">
                        <a href="{{ route('admin.orders.show', $order->id) }}"
                           class="inline-block bg-[#2a2a2a] hover:bg-[#F53003] text-white px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all shadow-lg active:scale-95">
                            Details
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center rounded-2xl bg-white/[0.02] border border-white/5">
                        <p class="text-gray-500 font-black uppercase italic tracking-widest text-[10px]">No incoming assets detected</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
