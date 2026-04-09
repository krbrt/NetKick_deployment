<x-admin-layout>
    <x-slot:headerTitle>Customer Database</x-slot>

    <div class="p-6 md:p-12 text-white font-sans bg-[#0A0A0A] min-h-screen">
        
        {{-- Header Section --}}
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
            <div>
                <h1 class="text-5xl font-black italic tracking-tighter uppercase leading-none">
                    Customer <span class="text-white">Database</span>
                </h1>
                <p class="text-[10px] text-[#F53003] font-black uppercase tracking-[0.4em] mt-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#F53003] animate-pulse"></span>
                    Verified User Segments • {{ $customers->total() }} Total Accounts
                </p>
            </div>
            
            <div class="relative group">
                <input type="text" placeholder="SEARCH CUSTOMERS..." 
                    class="bg-[#111] border border-white/5 rounded-2xl px-6 py-4 text-[10px] font-black uppercase tracking-widest w-64 focus:outline-none focus:border-[#F53003] transition-all">
                <svg class="w-4 h-4 absolute right-4 top-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </div>
        </div>

        {{-- Customer Table --}}
        <div class="max-w-6xl mx-auto bg-[#111] border border-white/5 rounded-[2.5rem] overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/[0.02]">
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-500">Identity</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-500">Contact Info</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-500">Account Status</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-500">Joined</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($customers as $customer)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="p-8">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 bg-gradient-to-br from-[#F53003] to-[#801b02] rounded-full flex items-center justify-center font-black italic text-lg shadow-lg group-hover:scale-110 transition-transform text-white">
                                        {{ substr($customer->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black uppercase tracking-tight">{{ $customer->name }}</p>
                                        <p class="text-[9px] text-[#F53003] font-bold uppercase tracking-widest">Premium Member</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-8">
                                <p class="text-xs font-mono text-gray-400">{{ $customer->email }}</p>
                            </td>
                            <td class="p-8">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-green-500">Active</span>
                                </div>
                            </td>
                            <td class="p-8 text-[10px] font-bold text-gray-500 uppercase">
                                {{ $customer->created_at->format('M d, Y') }}
                            </td>
                            <td class="p-8">
                                <button class="bg-white/5 hover:bg-white/10 p-3 rounded-xl transition-all">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-20 text-center text-gray-600 font-black uppercase tracking-[0.5em] text-xs">
                                No customer records found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="max-w-6xl mx-auto mt-8 flex justify-center">
            {{ $customers->links() }}
        </div>
    </div>
</x-admin-layout>