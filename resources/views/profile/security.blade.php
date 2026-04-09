<div class="p-6 bg-white shadow rounded-lg">
    <h3 class="text-lg font-bold mb-4 uppercase tracking-tight">Two-Factor Authentication</h3>

    {{-- STEP 1: 2FA is NOT enabled --}}
    @if(! auth()->user()->two_factor_secret)
        <div class="text-sm text-gray-600 mb-4">
            Add additional security to your account by using two-factor authentication.
        </div>
        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
            @csrf
            <x-primary-button type="submit">
                Enable 2FA
            </x-primary-button>
        </form>

    {{-- STEP 2: 2FA is enabled but NOT YET confirmed (Pending Scan) --}}
    @elseif(auth()->user()->two_factor_secret && ! auth()->user()->two_factor_confirmed_at)
        <div class="mb-4">
            <p class="text-sm font-bold text-red-600">Finish Enabling 2FA</p>
            <p class="text-xs text-gray-500 mb-4">Scan this QR code with your authenticator app (Google Authenticator, Authy, etc.) and enter the 6-digit code below.</p>
            
            <div class="p-4 bg-white border inline-block rounded-lg shadow-inner">
                {!! auth()->user()->twoFactorQrCodeSvg() !!}
            </div>
        </div>

        <form method="POST" action="{{ url('user/confirmed-two-factor-authentication') }}">
            @csrf
            <div class="flex flex-col gap-2 w-48">
                <x-input-label for="code" value="6-Digit Code" />
                <x-text-input id="code" name="code" type="text" inputmode="numeric" pattern="[0-9]*" class="block w-full" required autofocus />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                
                <x-primary-button type="submit" class="mt-2">
                    Confirm Activation
                </x-primary-button>
            </div>
        </form>

    {{-- STEP 3: 2FA is fully active --}}
    @else
        <div class="p-4 bg-green-50 border border-green-200 rounded-xl mb-6">
            <p class="text-green-800 font-bold text-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                Two-Factor Authentication is Active
            </p>
        </div>

        {{-- Recovery Codes Section --}}
        <div class="mt-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3">Emergency Recovery Codes</p>
            <p class="text-xs text-gray-600 mb-4">Store these in a secure password manager. They can be used to access your account if your mobile device is lost.</p>
            
            <div class="grid grid-cols-2 gap-2 font-mono text-sm bg-white p-3 border rounded shadow-sm">
                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                    <div class="py-1 px-2 border-b border-gray-50">{{ $code }}</div>
                @endforeach
            </div>
        </div>

        {{-- Disable Button --}}
        <form method="POST" action="{{ url('user/two-factor-authentication') }}" class="mt-6">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs font-bold text-red-600 uppercase tracking-widest hover:underline">
                Disable 2FA
            </button>
        </form>
    @endif
</div>