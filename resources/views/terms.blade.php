<x-guest-layout>
    <div class="min-h-screen bg-white flex items-center justify-center px-6 py-20 font-sans">
        <div class="w-full max-w-2xl bg-[#f9f9f9] p-10 rounded-3xl border border-gray-100 shadow-sm">
            
            {{-- Header --}}
            <div class="mb-12">
                <h1 class="text-2xl font-black text-black uppercase tracking-tighter italic">
                    Terms of <span class="text-[#F53003]">Service</span>
                </h1>
                <p class="text-[9px] text-gray-400 uppercase tracking-[0.3em] mt-1 font-bold">NK-Vault Protocol // 2026</p>
            </div>

            {{-- Content Stack --}}
            <div class="space-y-10 text-gray-600 text-sm leading-relaxed">
                
                <section>
                    <h2 class="text-black font-bold uppercase text-[10px] tracking-widest mb-2 flex items-center gap-2">
                        <span class="w-1 h-1 bg-[#F53003]"></span> 01. Acceptance
                    </h2>
                    <p>By accessing the NETKICKS Vault, you acknowledge and accept these terms. If you do not agree, you must terminate your session immediately.</p>
                </section>

                <section>
                    <h2 class="text-black font-bold uppercase text-[10px] tracking-widest mb-2 flex items-center gap-2">
                        <span class="w-1 h-1 bg-[#F53003]"></span> 02. Data & Cookies
                    </h2>
                    <p>We employ cookies to optimize Vault performance. Continued use constitutes consent to our data retrieval methods.</p>
                </section>

                <section>
                    <h2 class="text-black font-bold uppercase text-[10px] tracking-widest mb-2 flex items-center gap-2">
                        <span class="w-1 h-1 bg-[#F53003]"></span> 03. License & IP
                    </h2>
                    <p>All materials are owned by NETKICKS. You may not republish, sell, or redistribute content from the Vault without written authorization.</p>
                </section>

                <section>
                    <h2 class="text-black font-bold uppercase text-[10px] tracking-widest mb-2 flex items-center gap-2">
                        <span class="w-1 h-1 bg-[#F53003]"></span> 04. Liability
                    </h2>
                    <p>Information is provided "as is." We are not liable for any loss or damage arising from the use of this website or external links.</p>
                </section>

            </div>

            {{-- Simple Action --}}
            <div class="mt-12 pt-8 border-t border-gray-200 flex justify-between items-center">
                <p class="text-[8px] text-gray-300 font-bold uppercase tracking-widest">ID: NK-2026</p>
                <a href="{{ route('login') }}" class="text-black hover:text-[#F53003] font-black uppercase tracking-[0.2em] text-[10px] transition-colors">
                    Acknowledge & Return →
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>