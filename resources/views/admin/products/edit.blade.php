<x-admin-layout>
    <div class="p-6 md:p-10 bg-[#0A0A0A] min-h-screen text-white font-sans">
        
        {{-- Header Section - Matching the Vault Style --}}
        <div class="mb-12">
            <div class="flex items-baseline gap-2">
                <h1 class="text-6xl font-black italic tracking-tighter uppercase leading-none">
                    Gear <span class="text-[#F53003]">Recalibration</span>
                </h1>
            </div>
            <div class="flex items-center gap-3 mt-4">
                <span class="w-3 h-3 rounded-full bg-[#00FF66] animate-pulse"></span>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.4em]">
                    System Status: Active Monitoring • ID: #{{ $product->id }}
                </p>
            </div>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                {{-- Product Name Card (Large) --}}
                <div class="md:col-span-3 bg-[#111111] border border-white/5 p-8 rounded-[2rem] hover:border-white/10 transition-all">
                    <label class="text-[9px] font-black uppercase tracking-[0.3em] text-[#F53003] mb-4 block">Product Designation</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                        class="w-full bg-transparent border-none p-0 text-white text-4xl font-black italic uppercase tracking-tighter focus:ring-0 outline-none">
                    <p class="text-[10px] text-gray-600 mt-2 uppercase font-bold tracking-widest">Main Database Entry</p>
                </div>

                {{-- Image Preview Card --}}
                <div class="md:col-span-1 bg-[#111111] border border-white/5 p-4 rounded-[2rem] flex flex-col items-center justify-center group relative overflow-hidden">
                    @if($product->image)
                        <img src="{{ $product->image_url }}" class="h-32 w-full object-contain mb-2 group-hover:opacity-20 transition-all">
                    @endif
                    <label class="cursor-pointer text-center">
                        <span class="text-[9px] font-black uppercase tracking-widest text-gray-500 group-hover:text-white transition-all">Replace Image</span>
                        <input type="file" name="image" class="hidden">
                    </label>
                </div>

                {{-- Price Card --}}
                <div class="bg-[#111111] border border-white/5 p-8 rounded-[2rem] hover:border-[#F53003]/30 transition-all">
                    <label class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-500 mb-4 block">Unit Price</label>
                    <div class="flex items-center">
                        <span class="text-3xl font-black italic text-white mr-1">₱</span>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required 
                            class="w-full bg-transparent border-none p-0 text-white text-5xl font-black italic tracking-tighter focus:ring-0 outline-none">
                    </div>
                    <p class="text-[9px] text-[#F53003] mt-2 font-black uppercase tracking-widest">Live Financials</p>
                </div>

                {{-- Stock Card --}}
                <div class="bg-[#111111] border border-white/5 p-8 rounded-[2rem]">
                    <label class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-500 mb-4 block">Inventory Stock</label>
                    <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" required 
                        class="w-full bg-transparent border-none p-0 text-white text-5xl font-black italic tracking-tighter focus:ring-0 outline-none">
                    <p class="text-[9px] text-gray-600 mt-2 font-black uppercase tracking-widest">Units Available</p>
                </div>

                {{-- Brand/Category Card --}}
                <div class="bg-[#111111] border border-white/5 p-8 rounded-[2rem]">
                    <label class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-500 mb-4 block">Brand & Classification</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" 
                        class="w-full bg-transparent border-none p-0 text-white text-2xl font-black uppercase italic tracking-tighter focus:ring-0 outline-none mb-2">
                    
                    <select name="category" class="w-full bg-[#0A0A0A] border border-white/10 rounded-xl p-2 text-[10px] font-black uppercase tracking-widest text-gray-400 focus:text-white outline-none">
                        <option value="Shoes" {{ $product->category == 'Shoes' ? 'selected' : '' }}>Shoes</option>
                        <option value="Clothes" {{ $product->category == 'Clothes' ? 'selected' : '' }}>Clothes</option>
                        <option value="Crocs" {{ $product->category == 'Crocs' ? 'selected' : '' }}>Crocs</option>
                    </select>
                </div>

                {{-- Sizes Card --}}
                <div class="bg-[#111111] border border-white/5 p-8 rounded-[2rem]">
                    <label class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-500 mb-4 block">Size Manifest</label>
                    <input type="text" name="sizes" value="{{ old('sizes', $product->sizes) }}" 
                        class="w-full bg-transparent border-none p-0 text-white text-2xl font-black italic tracking-tighter focus:ring-0 outline-none" placeholder="40-45=2 or 42=1, 43=3">
                    <p class="text-[9px] text-gray-600 mt-2 font-black uppercase tracking-widest">Format: 40-45=2 or 42=1 (qty auto-limited to 1-6). Leave blank if not available.</p>
                </div>

            </div>

            {{-- Action Buttons --}}
            <div class="mt-12 flex items-center gap-6">
                <button type="submit" class="bg-[#F53003] text-white px-12 py-5 rounded-2xl font-black uppercase tracking-[0.3em] text-[11px] hover:bg-white hover:text-black transition-all shadow-[0_0_20px_rgba(245,48,3,0.3)]">
                    Commit Changes →
                </button>
                <a href="{{ route('admin.inventory') }}" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-600 hover:text-white transition-all">
                    Abort Mission
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>