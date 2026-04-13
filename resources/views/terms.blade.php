<x-app-layout>
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
        <footer class="bg-black text-white pt-24 pb-12 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-16">
            <div class="flex flex-col items-center md:items-start">
                <h2 class="text-4xl font-black italic mb-2 tracking-tighter text-[#F53003]">NETKICKS</h2>
                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.3em]">Footwear | Clothes | Apparel</p>
            </div>

            @php
                $footerLinks = [
                    'Contact' => [
                        'Facebook' => 'https://www.facebook.com/profile.php?id=61555962290158',
                        'Email'    => 'mailto:support@netkicks.com',
                    ],
                    'Shop' => [
                        'New & Featured' => 'hn.featured',
                        'Clothes'        => 'hn.clothes',
                        'Shoes'          => 'hn.shoes',
                        'Crocs'          => 'hn.crocs',
                        'Sale'           => 'hn.sale',
                    ],
                    'Company' => [
                        'Privacy Policy' => 'privacy',
                        'Terms'          => 'terms',
                        'About Us'       => 'about',
                    ],
                ];
            @endphp

            @foreach($footerLinks as $title => $links)
            <div>
                <h4 class="font-bold mb-6 uppercase text-[11px] tracking-widest text-white/50">{{ $title }}</h4>
                <ul class="text-gray-400 text-xs space-y-3 font-bold uppercase tracking-wider">
                    @foreach($links as $label => $url)
                        <li>
                            <a href="{{ Route::has($url) ? route($url) : $url }}"
                               class="hover:text-[#F53003] transition-colors">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <div class="max-w-7xl mx-auto mt-20 pt-8 border-t border-white/5 text-center">
            <p class="text-[9px] text-gray-600 uppercase font-black tracking-widest">© 2026 NETKICKS GLOBAL. All Rights Reserved.</p>
        </div>
    </footer>
</x-app-layout>