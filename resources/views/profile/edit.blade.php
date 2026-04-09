<x-app-layout>
    <div class="py-20 bg-[#1b1b18] min-h-screen flex flex-col items-center">
        
        {{-- Centered Simple Header --}}
        <div class="text-center mb-16">
            <h2 class="font-black text-5xl text-white uppercase tracking-tighter italic">
                {{ __('Profile Settings') }}
            </h2>
        </div>

        <div class="w-full max-w-2xl px-6 space-y-8">

            {{-- 1. Personal Information --}}
            <div class="p-8 bg-[#2a2a2a] border border-white/10 rounded-3xl shadow-2xl">
                <h3 class="text-white font-black uppercase text-[11px] tracking-[0.2em] mb-8 border-b border-white/5 pb-4">01. Profile Info</h3>
                <div class="nk-form-container">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- 2. Security & Password --}}
            <div class="p-8 bg-[#2a2a2a] border border-white/10 rounded-3xl shadow-2xl">
                <h3 class="text-white font-black uppercase text-[11px] tracking-[0.2em] mb-8 border-b border-white/5 pb-4">02. Password Vault</h3>
                <div class="nk-form-container">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- 3. Two-Factor Authentication --}}
            <div class="p-8 bg-[#2a2a2a] border border-white/10 rounded-3xl shadow-2xl">
                <h3 class="text-white font-black uppercase text-[11px] tracking-[0.2em] mb-8 border-b border-white/5 pb-4">03. Security Access</h3>
                <div class="nk-form-container">
                    @include('profile.security')
                </div>
            </div>

            {{-- 4. Danger Zone --}}
            <div class="p-8 bg-black border border-red-900/40 rounded-3xl shadow-2xl">
                <h3 class="text-red-600 font-black uppercase text-[11px] tracking-[0.2em] mb-8 border-b border-red-900/10 pb-4">04. Termination Zone</h3>
                <div class="nk-form-container">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <div class="text-center pt-8">
                <span class="text-[8px] text-white/20 uppercase tracking-[0.5em] font-black">NETKICKS GLOBAL &copy; 2026</span>
            </div>
        </div>
    </div>

    <style>
        /* Typography Clean up */
        .nk-form-container section header h2 { display: none; }
        .nk-form-container section header p {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        /* Centered Inputs & Labels */
        .nk-form-container label {
            color: #ffffff;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.2em;
            margin-bottom: 0.75rem;
            display: block;
        }

        .nk-form-container input {
            background-color: #1b1b18 !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            color: white !important;
            border-radius: 0.75rem !important;
            padding: 1rem !important;
            font-size: 0.9rem !important;
            width: 100% !important;
            transition: all 0.3s ease;
        }

        .nk-form-container input:focus {
            border-color: #F53003 !important;
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(245, 48, 3, 0.2) !important;
        }

        /* Consistent Blocky Buttons */
        .nk-form-container button[type="submit"],
        .nk-form-container .inline-flex.items-center.px-4.py-2.bg-gray-800,
        .nk-form-container .inline-flex.items-center.px-4.py-2.bg-red-600 {
            background-color: #F53003 !important;
            color: white !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.2em !important;
            font-size: 11px !important;
            border-radius: 0.75rem !important;
            padding: 1rem 2rem !important;
            border: none !important;
            transition: all 0.3s ease !important;
            width: 100% !important; /* Full width for mobile/simple look */
            cursor: pointer;
        }

        .nk-form-container button[type="submit"]:hover {
            background-color: white !important;
            color: #F53003 !important;
        }

        /* Success Text */
        .nk-form-container .text-sm.text-gray-600 {
            color: #F53003 !important;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 10px;
            display: block;
            margin-top: 1rem;
            text-align: center;
        }
    </style>
</x-app-layout>