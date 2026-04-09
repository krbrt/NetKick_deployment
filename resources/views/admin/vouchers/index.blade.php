<x-admin-layout>
    <div class="min-h-screen bg-[#0A0A0A] p-6 text-white font-sans">

        {{-- Header --}}
        <div class="max-w-3xl mx-auto flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-black italic uppercase tracking-tighter">
                    Add <span class="text-[#F53003]">Voucher</span>
                </h1>
                <p class="text-[10px] text-gray-500 uppercase tracking-widest mt-1">Management / New Entry</p>
            </div>
            <a href="{{ route('admin.home') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-white transition-colors">
                ← Back
            </a>
        </div>

        {{-- Form Card --}}
        <div class="max-w-3xl mx-auto bg-[#111] border border-white/5 rounded-3xl p-8 shadow-xl">
            <form action="{{ route('admin.vouchers.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Code --}}
                <div class="grid gap-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Voucher Code</label>
                    <input type="text" name="code" required value="{{ old('code') }}"
                           class="w-full bg-black border border-white/10 rounded-xl px-5 py-4 text-white focus:border-[#F53003] outline-none uppercase font-bold tracking-widest placeholder:text-gray-800"
                           placeholder="NETKICKS2026">
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Type --}}
                    <div class="grid gap-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Reduction Type</label>
                        <select name="type" class="w-full bg-black border border-white/10 rounded-xl px-5 py-4 text-white focus:border-[#F53003] outline-none font-bold uppercase text-xs">
                            <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (₱)</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="grid gap-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Status</label>
                        <select name="status" class="w-full bg-black border border-white/10 rounded-xl px-5 py-4 text-white focus:border-[#F53003] outline-none font-bold uppercase text-xs">
                            <option value="active">Active</option>
                            <option value="disabled">Disabled / Queued</option>
                        </select>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Value --}}
                    <div class="grid gap-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Value</label>
                        <input type="number" name="discount" required step="0.01" value="{{ old('discount') }}"
                               class="w-full bg-black border border-white/10 rounded-xl px-5 py-4 text-white focus:border-[#F53003] outline-none font-bold"
                               placeholder="0.00">
                    </div>

                    {{-- Expiry --}}
                    <div class="grid gap-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Expiry Date</label>
                        <input type="date" name="expiry" required value="{{ old('expiry') }}"
                               class="w-full bg-black border border-white/10 rounded-xl px-5 py-4 text-white focus:border-[#F53003] outline-none font-bold">
                    </div>
                </div>

                {{-- Limit --}}
                <div class="grid gap-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-500">Usage Limit</label>
                    <input type="number" name="limit" value="{{ old('limit') }}"
                           class="w-full bg-black border border-white/10 rounded-xl px-5 py-4 text-white focus:border-[#F53003] outline-none font-bold"
                           placeholder="Leave empty for unlimited">
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-[#F53003] hover:bg-[#ff3b0d] text-white py-5 rounded-xl font-black uppercase text-[10px] tracking-[0.2em] transition-all transform active:scale-95 shadow-lg shadow-[#F53003]/20">
                    Save Voucher
                </button>
            </form>
        </div>
    </div>
</x-admin-layout>
