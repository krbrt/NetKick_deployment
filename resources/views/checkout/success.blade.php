<x-app-layout>
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 min-h-screen pt-20 pb-12">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <div class="w-24 h-24 bg-green-500 rounded-full mx-auto mb-8 flex items-center justify-center shadow-2xl">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-4xl font-black uppercase italic tracking-tighter text-gray-900 mb-4">Order Confirmed!</h1>

            <p class="text-xl font-bold text-gray-600 mb-8">Thank you for your purchase. Your order has been received and is being processed.</p>

            <div class="bg-white rounded-3xl p-8 shadow-xl mb-12">
                <h2 class="text-2xl font-black uppercase mb-6">Order Details</h2>
                <div class="text-left space-y-3">
                    <p><span class="font-bold text-gray-500">Order Number:</span> <span class="font-black text-[#F53003]">#{{ session('order_number') ?? 'NK-ABC123' }}</span></p>
                    <p><span class="font-bold text-gray-500">Status:</span> <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-bold">Pending</span></p>
                    <p><span class="font-bold text-gray-500">Est. Delivery:</span> <span class="font-bold">3-5 business days</span></p>
                </div>
            </div>

            <div class="space-y-4">

                <a href="{{ route('home') }}" class="inline-block text-gray-600 underline font-bold uppercase tracking-wider hover:text-gray-900">
                    Continue Shopping →
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
