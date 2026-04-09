<x-admin-layout>
    <div class="min-h-screen bg-[#0A0A0A] p-6 md:p-12 text-white font-sans">

        {{-- Header Section --}}
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
            <div>
                <h1 class="text-5xl font-black italic tracking-tighter uppercase leading-none">
                    Sales <span class="text-white">Report</span>
                </h1>
                <p class="text-[10px] text-[#F53003] font-black uppercase tracking-[0.4em] mt-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#F53003] animate-pulse"></span>
                    Live Financial Data • Fiscal Year 2026
                </p>
            </div>

            {{-- Date Range Filter --}}
            <div class="flex bg-[#111] p-2 rounded-2xl border border-white/5">
                <button class="px-6 py-3 rounded-xl bg-[#F53003] text-white text-[10px] font-black uppercase tracking-widest transition-all">Daily</button>
                <button class="px-6 py-3 rounded-xl text-gray-500 hover:text-white text-[10px] font-black uppercase tracking-widest transition-all">Weekly</button>
                <button class="px-6 py-3 rounded-xl text-gray-500 hover:text-white text-[10px] font-black uppercase tracking-widest transition-all">Monthly</button>
            </div>
        </div>

        {{-- Top Metrics Row --}}
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-[#111] border border-white/5 p-8 rounded-[2.5rem] relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Total Gross Revenue</p>
                <h2 class="text-4xl font-black italic tracking-tighter">₱{{ number_format($totalRevenue ?? 0, 2) }}</h2>
                <p class="text-[10px] text-[#F53003] font-bold mt-4">+12.5% vs last month</p>
            </div>

            <div class="bg-[#111] border border-white/5 p-8 rounded-[2.5rem] relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Total Orders</p>
                <h2 class="text-4xl font-black italic tracking-tighter">{{ $totalOrders ?? 0 }}</h2>
                <div class="flex items-center gap-2 mt-4">
                    <span class="w-full h-1 bg-white/5 rounded-full overflow-hidden">
                        <span class="block h-full bg-[#F53003] w-[70%]"></span>
                    </span>
                </div>
            </div>

            <div class="bg-[#111] border border-white/5 p-8 rounded-[2.5rem] relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Avg. Basket Value</p>
                <h2 class="text-4xl font-black italic tracking-tighter">₱{{ number_format($avgOrder ?? 0, 2) }}</h2>
                <p class="text-[10px] text-gray-400 font-bold mt-4 uppercase tracking-widest">Optimized performance</p>
            </div>
        </div>

        {{-- Detailed Sales Table --}}
        <div class="max-w-6xl mx-auto bg-[#111] border border-white/5 rounded-[2.5rem] overflow-hidden shadow-2xl">
            <div class="p-8 border-b border-white/5 flex justify-between items-center">
                <h3 class="text-xl font-black italic uppercase tracking-tighter">Transaction Logs</h3>
                <button class="bg-white/5 hover:bg-white/10 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Export CSV</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/[0.02]">
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Order ID</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Customer</th>
                            {{-- Addressed inserted here --}}
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Delivery Address</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Items</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Total</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Status</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($sales as $sale)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="p-6 font-mono text-xs text-[#F53003]">#{{ $sale->order_number }}</td>
                            <td class="p-6">
                                <p class="text-sm font-bold">{{ $sale->customer_name }}</p>
                                <p class="text-[9px] text-gray-500 uppercase">{{ $sale->customer_email }}</p>
                            </td>
                            {{-- Address Data Cell --}}
                            <td class="p-6">
                                <p class="text-xs text-gray-400 group-hover:text-white transition-colors truncate max-w-[200px] italic">
                                    {{ $sale->address ?? 'Pick-up / Not Provided' }}
                                </p>
                            </td>
                            <td class="p-6 text-sm">{{ $sale->items_count }} Units</td>
                            <td class="p-6 text-sm font-black">₱{{ number_format($sale->total, 2) }}</td>
                            <td class="p-6">
                                <span class="px-3 py-1 bg-green-500/10 text-green-500 rounded-lg text-[9px] font-black uppercase tracking-widest">Success</span>
                            </td>
                            <td class="p-6 text-[10px] font-bold text-gray-500 uppercase">{{ $sale->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-20 text-center text-gray-600 font-black uppercase tracking-[0.5em] text-xs">No transaction history detected</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
