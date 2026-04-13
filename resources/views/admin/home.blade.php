<x-admin-layout>
    <x-slot:headerTitle>Vault Overview</x-slot>

    <div class="max-w-7xl mx-auto">
        {{-- Header Section --}}
        <div class="mb-12">
            <h1 class="text-7xl font-black italic tracking-tighter uppercase leading-none text-white">
                Dashboard <span class="text-[#F53003]">Overview</span>
            </h1>
            <p class="text-[10px] text-gray-500 font-black uppercase tracking-[0.4em] mt-4 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                System Status • {{ now()->format('M d, Y') }}
            </p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            {{-- Revenue --}}
            <div class="bg-[#111] p-8 rounded-[2.5rem] border border-white/5 relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase text-gray-500 mb-4 tracking-widest">Total Revenue</p>
                <h2 class="text-4xl font-black italic tracking-tighter text-white">₱{{ number_format($revenue ?? 0, 2) }}</h2>
                <p class="text-[9px] text-green-500 font-bold uppercase tracking-widest mt-4 italic">Live Financials</p>
            </div>

            {{-- Inventory --}}
            <a href="{{ route('admin.inventory') }}" class="bg-[#111] p-8 rounded-[2.5rem] border border-white/5 hover:border-[#F53003]/40 transition-all block group">
                <p class="text-[10px] font-black uppercase text-gray-500 mb-4 tracking-widest group-hover:text-gray-400">Inventory Count</p>
                <h2 class="text-4xl font-black italic tracking-tighter text-white">{{ $productsCount ?? 0 }} Items</h2>
                <p class="text-[9px] text-[#F53003] font-bold uppercase tracking-widest mt-4 group-hover:translate-x-1 transition-transform">Manage Vault →</p>
            </a>

            {{-- Customers --}}
            <div class="bg-[#111] p-8 rounded-[2.5rem] border border-white/5">
                <p class="text-[10px] font-black uppercase text-gray-500 mb-4 tracking-widest">Active Customers</p>
                <h2 class="text-4xl font-black italic tracking-tighter text-white">{{ $customersCount ?? 0 }}</h2>
                <p class="text-[9px] text-[#F53003] font-bold uppercase tracking-widest mt-4 italic">Verified Accounts</p>
            </div>

            {{-- Vouchers --}}
            <div class="bg-[#111] p-8 rounded-[2.5rem] border border-white/5">
                <p class="text-[10px] font-black uppercase text-gray-500 mb-4 tracking-widest">Active Vouchers</p>
                <h2 class="text-4xl font-black italic tracking-tighter text-white">{{ $vouchersCount ?? 0 }}</h2>
                <p class="text-[9px] text-[#F53003] font-bold uppercase tracking-widest mt-4 italic">Global Discounts</p>
            </div>
        </div>


        {{-- Recent Transactions Feed --}}
        <div class="bg-[#111] border border-white/5 rounded-[2.5rem] overflow-hidden shadow-2xl">
            <div class="p-8 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-4 bg-[#F53003]"></div>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-white">Recent Transactions</h3>
                </div>
                <button class="bg-white/5 hover:bg-white/10 text-white px-6 py-2 rounded-full text-[9px] font-black uppercase tracking-widest transition-all border border-white/5">View Analytics</button>
            </div>

            <div class="p-8 min-h-[300px]">
                @if(isset($transactions) && $transactions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[9px] font-black uppercase text-gray-600 tracking-[0.3em] border-b border-white/5 italic">
                                    <th class="pb-6 px-4">Asset ID</th>
                                    <th class="pb-6 px-4">Ref No.</th> {{-- NEW COLUMN HEADER --}}
                                    <th class="pb-6 px-4">Customer</th>
                                    <th class="pb-6 px-4">Destination</th>
                                    <th class="pb-6 px-4">Quantity</th>
                                    <th class="pb-6 px-4">Payment</th>
                                    <th class="pb-6 px-4">Value</th>
                                    <th class="pb-6 px-4 text-center">Status</th>
                                    <th class="pb-6 px-4 text-right">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody class="text-[11px] font-bold uppercase tracking-widest">
                                @foreach($transactions as $tx)
                                    <tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition-all cursor-pointer group" onclick="window.location.href = '{{ route('admin.orders.show', $tx->id) }}'">
                                        <td class="py-6 px-4 text-[#F53003] italic font-black">#{{ $tx->order_number ?? $tx->id }}</td>

                                        {{-- NEW REFERENCE NUMBER CELL --}}
                                        <td class="py-6 px-4">
                                            <span class="bg-white/5 px-2 py-1 rounded text-gray-400 text-[9px] border border-white/5 font-mono tracking-widest">
                                                {{ $tx->reference_number ?? '---' }}
                                            </span>
                                        </td>

                                        <td class="py-6 px-4">
                                            <span class="text-white italic">{{ $tx->first_name }} {{ $tx->last_name }}</span>
                                            <br><span class="text-[9px] text-gray-500 font-medium normal-case tracking-normal">{{ $tx->phone }}</span>
                                        </td>

                                        <td class="py-6 px-4">
                                            <p class="text-gray-500 group-hover:text-gray-300 transition-colors truncate max-w-[150px] italic font-medium lowercase tracking-normal">
                                                {{ $tx->shipping_address ?? $tx->address ?? 'Vault Pick-up' }}
                                            </p>
                                        </td>

                                        <td class="py-6 px-4">
                                            <span class="bg-[#1a1a1a] px-3 py-1 rounded-lg border border-white/5 text-white group-hover:border-[#F53003]/30 transition-all">
                                                {{ $tx->items->sum('quantity') ?? $tx->total_items ?? 0 }} <span class="text-[9px] text-gray-500 italic">PCS</span>
                                            </span>
                                        </td>

                                        <td class="py-6 px-4">
                                            <div class="flex flex-col gap-1">
                                                <span class="text-[10px] text-white/80 font-black italic">{{ strtoupper($tx->payment_method ?? 'N/A') }}</span>
                                                <div class="flex items-center gap-1.5">
                                                    @if($tx->status == 'paid' || $tx->status == 'completed' || ($tx->payment_method == 'gcash' && $tx->status != 'pending'))
                                                        <span class="w-1 h-1 rounded-full bg-green-500"></span>
                                                        <span class="text-[8px] text-green-500 font-black italic">PAID</span>
                                                    @else
                                                        <span class="w-1 h-1 rounded-full bg-[#F53003]"></span>
                                                        <span class="text-[8px] text-[#F53003] font-black italic">PENDING</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-6 px-4 text-white font-black italic">
                                            ₱{{ number_format($tx->total_amount ?? 0, 2) }}
                                        </td>

                                        <td class="py-6 px-4 text-center">
                                            <span class="px-3 py-1.5 rounded-full text-[8px] font-black tracking-widest border 
                                                {{ $tx->status == 'completed' 
                                                    ? 'border-green-500/30 text-green-500 bg-green-500/5' 
                                                    : 'border-white/10 text-gray-500 bg-white/5' }}">
                                                {{ strtoupper($tx->status) }}
                                            </span>
                                        </td>
                                        <td class="py-6 px-4 text-right text-gray-600 font-black text-[9px] italic">{{ $tx->created_at->format('M d • H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="h-full flex flex-col items-center justify-center text-center py-24 opacity-20">
                        <svg class="w-12 h-12 text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002 2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p class="text-[10px] font-black uppercase tracking-[0.5em] text-white">Real-time feed active • No records found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>