<x-app-layout>
    <div class="bg-white min-h-screen pt-20 pb-12">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-4xl font-black uppercase italic tracking-tighter mb-10">Checkout</h1>

            <form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                @csrf

                {{-- LEFT: SHIPPING & BILLING --}}
                <div class="lg:col-span-7 space-y-12">
                    {{-- Shipping Section --}}
                    <section>
                        <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6 flex items-center gap-2">
                            <span class="w-8 h-px bg-gray-200"></span> Shipping Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="first_name" placeholder="First Name" required
                                class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-[#F53003] transition-all">
                            <input type="text" name="last_name" placeholder="Last Name" required
                                class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-[#F53003] transition-all">
                        </div>

                        <div class="mt-4">
                            <input type="text" name="address" placeholder="Complete Address (Street, Barangay, City)" required
                                class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-[#F53003] transition-all">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <input type="text" name="phone" placeholder="Phone Number (e.g. 0912...)" required
                                class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-[#F53003] transition-all">
                            <input type="email" name="email" value="{{ auth()->user()->email }}" readonly
                                class="w-full bg-gray-100 border-none rounded-xl p-4 text-gray-500 cursor-not-allowed">
                        </div>
                    </section>

                    {{-- Payment Method Section --}}
                    <section>
                        <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6 flex items-center gap-2">
                            <span class="w-8 h-px bg-gray-200"></span> Payment Method
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- COD Option --}}
                            <label class="relative cursor-pointer group">
                                {{-- Idinagdag ang handlePaymentChange dito --}}
                                <input type="radio" name="payment_method" value="cod" class="peer hidden" checked onchange="handlePaymentChange(this)">
                                <div class="p-6 border-2 border-gray-100 rounded-2xl text-center peer-checked:border-[#F53003] peer-checked:bg-[#F53003]/5 transition-all">
                                    <span class="block font-black uppercase text-[11px] italic tracking-widest">Cash on Delivery</span>
                                    <p class="text-[9px] text-gray-400 uppercase mt-1">Pay when you receive</p>
                                </div>
                            </label>

                            {{-- GCash Option --}}
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="payment_method" value="gcash" class="peer hidden" onchange="handlePaymentChange(this)">
                                <div class="p-6 border-2 border-gray-100 rounded-2xl text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                                    <span class="block font-black uppercase text-[11px] italic tracking-widest text-blue-600">GCash</span>
                                    <p class="text-[9px] text-gray-400 uppercase mt-1">Enter reference number to proceed</p>
                                </div>
                            </label>
                        </div>

                        {{-- GCash Details Box --}}
                        <div id="gcash-ref" class="hidden mt-6 p-8 bg-blue-50/50 border-2 border-blue-100 rounded-[2.5rem] animate-in fade-in slide-in-from-top-4 duration-500">
                            <div class="flex flex-col md:flex-row items-center gap-8">
                                <div class="w-32 h-32 bg-white p-2 rounded-2xl shadow-sm border border-blue-100 flex-shrink-0 overflow-hidden">
                                    <img src="{{ asset('images/netkicks-qr.jpg') }}" alt="GCash QR" class="w-full h-full object-cover rounded-xl">
                                </div>

                                <div class="flex-1 text-center md:text-left space-y-4">
                                    <div>
                                        <h4 class="text-sm font-black uppercase italic text-blue-900 tracking-tight">Pay via GCash</h4>
                                        <p class="text-[10px] text-blue-700/70 font-bold uppercase tracking-widest mt-1">Exact amount: ₱{{ number_format($total) }}</p>
                                    </div>

                                    <div class="bg-white/60 p-4 rounded-xl inline-block border border-blue-100">
                                        <p class="text-[9px] text-gray-500 uppercase font-black tracking-widest">Number</p>
                                        <p class="text-lg font-black text-blue-600">0916 371 2961</p>
                                    </div>

                                    <input type="text" id="gcash_input" name="gcash_reference" placeholder="Enter transaction reference/ID"
                                        class="w-full bg-white border border-blue-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 text-sm font-mono tracking-wide">
                                    <p class="text-[8px] text-blue-600 mt-1 font-bold uppercase">e.g. GC123456789 or TXN ID after payment</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- RIGHT: ORDER SUMMARY --}}
                <div class="lg:col-span-5">
                    <div class="bg-gray-50 rounded-[2.5rem] p-8 sticky top-24 border border-gray-100">
                        <h2 class="text-xl font-black uppercase italic mb-8">Order Summary</h2>

                        <div class="space-y-6 max-h-80 overflow-y-auto pr-2 mb-8 custom-scrollbar">
                            @foreach($cartItems as $id => $details)
                                <div class="flex items-center gap-4">
                                    <div class="w-20 h-20 bg-white rounded-2xl overflow-hidden flex-shrink-0 border border-gray-100">
                                        <img src="{{ asset($details['image']) }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-[11px] font-black uppercase leading-tight tracking-tight">{{ $details['name'] }}</h3>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Size: {{ $details['size'] }} | Qty: {{ $details['quantity'] }}</p>
                                    </div>
                                    <span class="text-xs font-black">₱{{ number_format($details['price'] * $details['quantity']) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 pt-6 space-y-3">
                            <div class="flex justify-between text-gray-500 text-[10px] font-black uppercase tracking-widest">
                                <span>Subtotal</span>
                                <span>₱{{ number_format($total) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500 text-[10px] font-black uppercase tracking-widest">
                                <span>Shipping</span>
                                <span class="text-green-600">FREE</span>
                            </div>
                            <div class="flex justify-between text-2xl font-black uppercase italic pt-4 border-t border-gray-200 mt-4">
                                <span>Total</span>
                                <span class="text-[#F53003]">₱{{ number_format($total) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-black text-white py-6 rounded-2xl mt-8 font-black uppercase italic tracking-widest hover:bg-[#F53003] transition-all shadow-2xl shadow-black/10 active:scale-[0.98]">
                            Place Order
                        </button>

                        <p class="text-[9px] text-center text-gray-400 mt-6 uppercase font-bold tracking-[0.2em]">
                            Secure encrypted checkout
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function handlePaymentChange(radio) {
            const gcashRef = document.getElementById('gcash-ref');
            const gcashInput = document.getElementById('gcash_input');

            if (radio.value === 'gcash') {
                gcashRef.classList.remove('hidden');
                gcashInput.setAttribute('required', 'required'); // Required lang kapag GCash
            } else {
                gcashRef.classList.add('hidden');
                gcashInput.removeAttribute('required'); // Alisin ang required kapag COD
                gcashInput.value = ''; // I-clear ang input
            }
        }
    </script>
</x-app-layout>
