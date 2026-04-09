<x-app-layout> {{-- Assuming you use a layout component --}}
    <h1>Account Security</h1>

    <div class="mt-5">
        @if(! auth()->user()->two_factor_secret)
            {{-- STEP A: ENABLE 2FA --}}
            <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    Enable Two-Factor Authentication
                </button>
            </form>
        @else
            {{-- STEP B: SHOW QR CODE & RECOVERY CODES --}}
            <div class="mb-4">
                <p>Two-factor authentication is now enabled. Scan the following QR code using your phone's authenticator application.</p>
                
                <div class="mt-4">
                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                </div>
            </div>

            <div class="mt-4">
                <p>Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two-factor authentication device is lost.</p>

                <div class="bg-gray-100 p-4 rounded">
                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            </div>

            {{-- STEP C: DISABLE 2FA --}}
            <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mt-4">
                    Disable Two-Factor Authentication
                </button>
            </form>
        @endif
    </div>
</x-app-layout>