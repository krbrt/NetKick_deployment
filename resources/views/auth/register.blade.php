<x-guest-layout>
    <div class="min-h-screen bg-[#F5F7FA] flex items-center justify-center px-4 font-sans">
        <div class="w-full max-w-[480px] bg-white p-12 rounded-3xl shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-gray-100">

            {{-- Title & Subtitle --}}
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold text-[#111111] tracking-tight">Sign Up</h1>
                <p class="text-[13px] text-gray-500 mt-2 font-medium">Please enter your details to create an account.</p>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 text-[12px] text-red-600 bg-red-50 p-4 rounded-xl border border-red-100 font-medium">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Form matching image style --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-[13px] font-semibold text-[#111111] mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full bg-white border border-gray-200 text-[#111111] text-sm px-4 py-3 rounded-xl focus:border-[#4169E1] focus:ring-1 focus:ring-[#4169E1] outline-none transition-all placeholder:text-gray-300">
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-[#111111] mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-white border border-gray-200 text-[#111111] text-sm px-4 py-3 rounded-xl focus:border-[#4169E1] focus:ring-1 focus:ring-[#4169E1] outline-none transition-all placeholder:text-gray-300">
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-[#111111] mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full bg-white border border-gray-200 text-[#111111] text-sm px-4 py-3 rounded-xl focus:border-[#4169E1] focus:ring-1 focus:ring-[#4169E1] outline-none transition-all placeholder:text-gray-300">
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-[#111111] mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full bg-white border border-gray-200 text-[#111111] text-sm px-4 py-3 rounded-xl focus:border-[#4169E1] focus:ring-1 focus:ring-[#4169E1] outline-none transition-all placeholder:text-gray-300">
                </div>

                <button type="submit"
                        class="w-full bg-[#305DF5] text-white font-semibold text-sm py-4 rounded-xl hover:bg-[#1E4DDF] transition-all active:scale-[0.98] mt-6 shadow-sm shadow-[#305DF5]/10">
                    Register
                </button>
            </form>

            {{-- Separator Line --}}
            <hr class="border-gray-100 my-10">

            {{-- Navigation/Links --}}
            <div class="text-center">
                <p class="text-[13px] text-gray-500 font-medium">
                    Already have an account? <a href="{{ route('login') }}" class="text-[#305DF5] hover:text-[#1E4DDF] font-semibold ml-1 transition-colors">Sign In</a>
                </p>
                <div class="mt-6">
                    <a href="{{ route('welcome') }}" class="text-[12px] text-gray-400 hover:text-[#111111] transition-colors font-medium">
                        ← Back to NETKICKS Store
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>