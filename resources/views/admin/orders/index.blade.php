<x-admin-layout>
    <x-slot:headerTitle>
        <span class="italic font-black uppercase tracking-tighter">Order Manifest</span>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Search & Filter --}}
        <div class="mb-8 flex flex-col lg:flex-row gap-4">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Orders, Customers..."
                    class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3 focus:ring-2 focus:ring-[#F53003] focus:border-transparent shadow-sm">
            </form>
            <select name="status" onchange="this.form.submit()" form="filter-form" class="bg-white border border-gray-200 rounded-xl px-5 py-3 focus:ring-2 focus:ring-[#F53003] shadow-sm">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        {{-- Orders Table --}}
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-[0_25px_50px_rgba(0,0,0,0.1)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                <span class="text-[11px] font-black uppercase tracking-wider text-gray-500">Order #</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-[11px] font-black uppercase tracking-wider text-gray-500">Customer</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-[11px] font-black uppercase tracking-wider text-gray-500">Phone</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-[11px] font-black uppercase tracking-wider text-gray-500">Address</span>
                            </th>
                            <th class="px-6 py-4 text-right">
                                <span class="text-[11px] font-black uppercase tracking-wider text-gray-500">Total</span>
                            </th>
                            <th class="px-6 py-4 text-center">
                                <span class="text-[11px] font-black uppercase tracking-wider text-gray-500">Status</span>
                            </th>
                            <th class="px-6 py-4 text-right">
                                <span class="text-[11px] font-black uppercase tracking-wider text-gray-500">Date</span>
                            </th>
                            <th class="px-6 py-4 text-right">
                                <span class="text-[11px] font-black uppercase tracking-wider text-gray-500">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer" onclick="window.location.href = '{{ route('admin.orders.show', $order->id) }}'">
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-3">
                                    <span class="font-mono font-bold text-lg tracking-tight text-[#1b1b18] bg-[#F53003]/10 px-3 py-1 rounded-full">#{{ $order->order_number }}</span>
                                    <span class="text-xs font-bold uppercase text-gray-400">{{ $order->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <p class="font-black italic uppercase text-sm text-[#1b1b18] tracking-tight">{{ $order->first_name }} {{ $order->last_name }}</p>
                                    <p class="text-[9px] font-medium text-gray-400">{{ $order->phone }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <p class="text-sm font-semibold text-gray-700">{{ substr($order->address, 0, 35) }}...</p>
                            </td>
                            <td class="px-6 py-6 text-right">
                                <span class="font-bold italic text-xl text-[#1b1b18]">₱ {{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}</span>
</xai:function_call >

<xai:function_call name="edit_file">
<parameter name="path">c:/Users/SUNSHINE/Documents/GitHub/Netkicks/resources/views/admin/orders/show.blade.php
                            </td>
                            <td class="px-6 py-6 text-center">
                                <span class="px-4 py-2 rounded-full text-[10px] font-black uppercase italic tracking-widest bg-gradient-to-r {{ $order->status == 'pending' ? 'from-orange-400 to-orange-500 text-white' : ($order->status == 'delivered' ? 'from-emerald-400 to-emerald-500 text-white' : 'from-gray-400 to-gray-500 text-white') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-6 text-right">
                                <span class="text-sm font-bold text-gray-500 uppercase">{{ $order->created_at->format('M d') }}</span>
                            </td>
                            <td class="px-6 py-6 text-right">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="p-2 hover:bg-gray-100 rounded-xl transition-all">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs bg-transparent border-none p-1 rounded focus:ring-1 focus:ring-[#F53003]">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ $order->status == 'processing' ? 'selected' : '' }} >Shipped</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-20 text-center">
                                <p class="text-lg text-gray-500 font-bold uppercase tracking-wider">No orders found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-12 flex justify-center">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
</x-admin-layout>

