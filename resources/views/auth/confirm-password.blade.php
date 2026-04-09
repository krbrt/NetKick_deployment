<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing to manage your Two-Factor Authentication settings.') }}
    </div>

    {{-- Fortify expects the POST request to go to /user/confirm-password --}}
    <form method="POST" action="{{ url('user/confirm-password') }}">
        @csrf

        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            autofocus />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>