<x-admin-layout>
    <x-slot:headerTitle>Vault Overview</x-slot>

    <div class="max-w-7xl mx-auto">
        {{-- Header Section --}}
        <div class="mb-12">
            <h1 class="text-7xl font-black italic tracking-tighter uppercase leading-none">
                Dashboard <span class="text-[#F53003]">Overview</span>
            </h1>
            <p class="text-[10px] text-gray-500 font-black uppercase tracking-[0.4em] mt-4 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                System Status{{ now()->format('M d, Y') }}
            </p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            {{-- Revenue --}}
            <div class="bg-[#111] p-8 rounded-[2.5rem] border border-white/5 relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase text-gray-500 mb-4 tracking-widest">Total Revenue</p>
                <h2 class="text-4xl font-black italic tracking-tighter text-white">₱{{ number_format($revenue ?? 0, 2) }}</h2>
                <p class="text-[9px] text-green-500 font-bold uppercase tracking-widest mt-4">Live Financials</p>
            </div>

            {{-- Inventory --}}
            <a href="{{ route('admin.inventory') }}" class="bg-[#111] p-8 rounded-[2.5rem] border border-white/5 hover:border-[#F53003]/40 transition-all block group">
                <p class="text-[10px] font-black uppercase text-gray-500 mb-4 tracking-widest group-hover:text-gray-400">Inventory Count</p>
                <h2 class="text-4xl font-black italic tracking-tighter text-white">{{ $productsCount ?? 0 }} Items</h2>
                <p class="text-[9px] text-[#F53003] font-bold uppercase tracking-widest mt-4 group-hover:translate-x-1 transition-transform">Manage Vault →</p>
            </a>

            {{-- Customers --}}
            <div class="bg-[#111] p-8 rounded-[2.5rem] border border-white/5">
                <p class="text-[10px] font-black uppercase text-gray-500 mb-4 tracking-widest text-gray-500">Active Customers</p>
                <h2 class="text-4xl font-black italic tracking-tighter text-white">{{ $customersCount ?? 0 }}</h2>
                <p class="text-[9px] text-[#F53003] font-bold uppercase tracking-widest mt-4">Verified Accounts</p>
            </div>

            {{-- Vouchers --}}
            <div class="bg-[#111] p-8 rounded-[2.5rem] border border-white/5">
                <p class="text-[10px] font-black uppercase text-gray-500 mb-4 tracking-widest text-gray-500">Active Vouchers</p>
                <h2 class="text-4xl font-black italic tracking-tighter text-white">{{ $vouchersCount ?? 0 }}</h2>
                <p class="text-[9px] text-[#F53003] font-bold uppercase tracking-widest mt-4">Global Discounts</p>
            </div>
        </div>

        {{-- Test Checkout Button --}}
        <div class="mb-12">
            <a href="{{ route('checkout.index') }}" class="block w-full lg:w-auto bg-black text-white py-5 px-12 rounded-2xl font-black uppercase italic tracking-widest hover:bg-[#F53003] transition-all shadow-xl shadow-black/10 text-center max-w-max">
                Place Test Order (PayMongo Demo)
            </a>
        </div>

        {{-- Recent Transactions Feed --}}
        <div class="bg-[#111] border border-white/5 rounded-[2.5rem] overflow-hidden">
            <div class="p-8 border-b border-white/5 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-4 bg-[#F53003]"></div>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.3em]">Recent Transactions</h3>
                </div>
                <button class="bg-white text-black px-6 pZy-2 rounded-full text-[9px] font-black uppercase tracking-widest hover:bg-[#F53003] hover:text-white transition-all shadow-lg">View Analytics</button>
            </div>
<div class="p-8 min-h-[300px]">
    @if(isset($transactions) && $transactions->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[9px] font-black uppercase text-gray-600 tracking-[0.2em] border-b border-white/5">
                        <th class="pb-6 px-4">Asset ID</th>
                        <th class="pb-6 px-4">Customer</th>
                        {{-- New Column Header --}}
                        <th class="pb-6 px-4">Destination</th>
                        <th class="pb-6 px-4">Value</th>
                        <th class="pb-6 px-4 text-center">Status</th>
                        <th class="pb-6 px-4 text-right">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="text-[11px] font-bold uppercase tracking-widest">
                    @foreach($transactions as $tx)
                        <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors cursor-pointer group" onclick="window.location.href = '{{ route('admin.orders.show', $tx->id) }}'">
                            <td class="py-6 px-4 text-gray-400 group-hover:text-white">#{{ $tx->order_number ?? $tx->id }}</td>
                            <td class="py-6 px-4 text-white italic">{{ $tx->first_name }} {{ $tx->last_name }}<br><span class="text-xs text-gray-400">{{ $tx->phone }}</span></td>

                            <td class="py-6 px-4">
                                <p class="text-white/60 group-hover:text-white transition-colors truncate max-w-[180px] italic font-medium lowercase tracking-normal">
                                    {{ $tx->address ?? 'No Address Provided' }}
                                </p>
                            </td>

                            <td class="py-6 px-4 text-white">₱{{ number_format($tx->total_amount, 2) }}<br><span class="text-xs text-gray-400">{{ $tx->items->count() ?? 0 }} items</span></td>
                            <td class="py-6 px-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[8px] border {{ $tx->status == 'completed' ? 'border-green-500/30 text-green-500 bg-green-500/5' : 'border-[#F53003]/30 text-[#F53003] bg-[#F53003]/5' }}">
                                    {{ ucfirst($tx->status) }}
                                </span>
                            </td>
                            <td class="py-6 px-4 text-right text-gray-600 font-normal">{{ $tx->created_at->format('M d, H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        {{-- Empty State (No changes here) --}}
        <div class="h-full flex flex-col items-center justify-center text-center py-16 opacity-20">
            <svg class="w-12 h-12 text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002 2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <p class="text-[10px] font-black uppercase tracking-[0.5em]">Real-time feed active • No records found</p>
        </div>
    @endif
</div>
        </div>
    </div>
</x-admin-layout>
