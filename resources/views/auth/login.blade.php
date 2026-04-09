<x-guest-layout>
        
        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-md">
            {{-- Header --}}
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">{{ __('Sign In') }}</h2>
                <p class="text-sm text-gray-500 mt-1">Please enter your details to continue.</p>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                    {{ __('Login') }}
                </button>
            </form>

            {{-- Secondary Action --}}
            <div class="mt-8 text-center text-sm border-t border-gray-100 pt-6">
                <p class="text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">
                        {{ __('Register') }}
                    </a>
                </p>
            </div>
        </div>

</x-guest-layout>