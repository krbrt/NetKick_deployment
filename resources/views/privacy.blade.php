<x-guest-layout>
    <div class="min-h-screen bg-white flex items-center justify-center px-6 py-20 font-sans">
        <div class="w-full max-w-3xl bg-[#f9f9f9] p-10 md:p-16 rounded-[2.5rem] border border-gray-100 shadow-sm">
            
            {{-- Header --}}
            <div class="mb-16 border-b border-gray-200 pb-8">
                <h1 class="text-3xl font-black text-black uppercase tracking-tighter italic leading-none">
                    Privacy <span class="text-[#F53003]">Protocol</span>
                </h1>
                <div class="flex flex-col md:flex-row justify-between mt-4 gap-2">
                    <p class="text-[9px] text-gray-400 uppercase tracking-[0.3em] font-bold">NK-Vault Data Protection // 2026</p>
                    <p class="text-[9px] text-black uppercase tracking-[0.2em] font-black">Status: Secure</p>
                </div>
            </div>

            {{-- Simplified Content Sections --}}
            <div class="space-y-12 text-gray-600 text-[13px] leading-relaxed">
                
                {{-- 01. Consent & Scope --}}
                <section>
                    <h2 class="text-black font-black uppercase text-[10px] tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-[2px] bg-[#F53003]"></span> 01. User Consent
                    </h2>
                    <p>By accessing the NETKICKS Vault, you hereby consent to our Privacy Protocol and agree to its terms. This policy applies strictly to our online activities and is valid for all visitors to our digital infrastructure.</p>
                </section>

                {{-- 02. Data Acquisition --}}
                <section>
                    <h2 class="text-black font-black uppercase text-[10px] tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-[2px] bg-[#F53003]"></span> 02. Information Collection
                    </h2>
                    <p>When you register for a Vault Account, we may ask for your contact information including your <b>Name, Address, Email, and Phone Number</b>. If you contact us directly, we may receive additional metadata to assist with your inquiry.</p>
                </section>

                {{-- 03. Usage --}}
                <section>
                    <h2 class="text-black font-black uppercase text-[10px] tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-[2px] bg-[#F53003]"></span> 03. Protocol Usage
                    </h2>
                    <p>We use collected data to operate and maintain the Vault, analyze user movement to improve functionality, and prevent fraudulent access attempts to restricted inventory.</p>
                </section>

                {{-- 04. Technical Logs & Cookies --}}
                <section>
                    <h2 class="text-black font-black uppercase text-[10px] tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-[2px] bg-[#F53003]"></span> 04. Digital Footprint
                    </h2>
                    <p>NETKICKS follows standard log file procedures. This includes IP addresses, browser types, and date/time stamps. We also employ <b>Cookies</b> to optimize your experience based on your specific browser profile.</p>
                </section>

                {{-- 05. Rights --}}
                <section class="bg-white p-6 rounded-2xl border border-gray-100">
                    <h2 class="text-black font-black uppercase text-[10px] tracking-widest mb-4">Data Rights (GDPR & CCPA)</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-[11px] uppercase font-bold tracking-tight text-gray-400">
                        <div class="flex items-center gap-2"><span class="text-[#F53003]">/</span> Right to Erasure</div>
                        <div class="flex items-center gap-2"><span class="text-[#F53003]">/</span> Right to Object</div>
                        <div class="flex items-center gap-2"><span class="text-[#F53003]">/</span> Right to Access</div>
                        <div class="flex items-center gap-2"><span class="text-[#F53003]">/</span> Right to Portability</div>
                    </div>
                </section>

                {{-- 06. Contact --}}
                <section>
                    <p class="italic">Questions regarding the Vault Protocol? Contact us via encrypted line: <span class="text-black font-bold not-italic underline decoration-[#F53003]">support@netkicks.com</span></p>
                </section>

            </div>

            {{-- Simple Action Footer --}}
            <div class="mt-16 pt-8 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-[8px] text-gray-300 font-bold uppercase tracking-widest">ENCRYPT-ID: NK-SECURE-2026</p>
                <a href="{{ route('login') }}" class="w-full md:w-auto text-center bg-black text-white hover:bg-[#F53003] font-black uppercase tracking-[0.2em] text-[10px] px-8 py-4 rounded-xl transition-all">
                    Acknowledge & Return →
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>