@extends('layouts.admin') {{-- Or whatever your base layout is --}}

@section('content')
<div class="flex items-center justify-center min-h-screen bg-[#050505] p-6">
    <div class="w-full max-w-md p-8 rounded-2xl border border-white/10 bg-white/[0.02] backdrop-blur-xl">
        
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-500/10 text-[#F53003] mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h2 class="text-xl font-black uppercase tracking-tighter text-white">Confirm Removal</h2>
            <p class="text-gray-500 text-sm mt-2">
                Are you sure you want to remove <strong>{{ $product->name }}</strong> from the inventory? This action cannot be undone.
            </p>
        </div>

        <div class="flex flex-col gap-3">
            {{-- THE ACTUAL DELETE FORM --}}
            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="m-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-4 rounded-xl bg-[#F53003] text-white font-black uppercase tracking-widest text-xs hover:bg-[#ff3c00] transition-all shadow-[0_0_20px_rgba(245,48,3,0.3)]">
                    Permanently Delete
                </button>
            </form>

            {{-- CANCEL BUTTON --}}
            <a href="{{ route('admin.products.index') }}" class="w-full py-4 rounded-xl border border-white/10 bg-white/5 text-gray-400 font-black uppercase tracking-widest text-xs text-center hover:bg-white/10 hover:text-white transition-all">
                Keep Product
            </a>
        </div>
        
    </div>
</div>
@endsection