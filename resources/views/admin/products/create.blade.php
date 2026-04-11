<x-admin-layout>
    <x-slot:headerTitle>Add New Product</x-slot>

    <div class="max-w-4xl mx-auto py-12 px-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- 1. BASIC INFO --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase text-gray-500 tracking-wider">Product Name</label>
                    <input type="text" name="name" placeholder="e.g. Nike Dunk Low" required
                        class="w-full bg-[#111] border border-white/10 rounded-xl p-4 text-white focus:border-[#F53003] focus:ring-0 transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase text-gray-500 tracking-wider">Brand</label>
                    <select name="brand" id="brand-select" onchange="checkNewBrand(this)"
                        class="w-full bg-[#111] border border-white/10 rounded-xl p-4 text-white focus:border-[#F53003] outline-none">
                        <option value="Nike">Nike</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Adidas">Adidas</option>
                        <option value="Crocs">Crocs</option>
                        <option value="OTHER">Other Brand...</option>
                    </select>
                    <input type="text" id="new-brand-input" name="new_brand" placeholder="Type Brand Name..."
                        class="hidden w-full mt-2 bg-[#111] border border-[#F53003]/50 rounded-xl p-4 text-white italic focus:ring-0">
                </div>
            </div>

            {{-- 2. PRODUCT TYPE & CATEGORY --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase text-gray-500 tracking-wider">Product Type</label>
                    <select name="type" id="type-select" required
                        class="w-full bg-[#111] border border-white/10 rounded-xl p-4 text-white focus:border-[#F53003] outline-none">
                        <option value="" disabled selected>Select Type</option>
                        <option value="Footwear">Footwear (Shoes/Crocs)</option>
                        <option value="Apparel">Apparel (Clothes)</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase text-gray-500 tracking-wider">Specific Category</label>
                    <select name="category" id="category-select" onchange="autoSelectType(this)"
                        class="w-full bg-[#111] border border-white/10 rounded-xl p-4 text-white focus:border-[#F53003] outline-none">
                        <option value="" disabled selected>Select Category</option>

                        <optgroup label="Footwear">
                            <option value="Basketball Shoes">Basketball Shoes</option>
                            <option value="Running Shoes">Running Shoes</option>
                            <option value="Lifestyle Sneakers">Lifestyle Sneakers</option>
                            <option value="Jordan Brand">Jordan Brand</option>
                        </optgroup>

                        <optgroup label="Apparel (Clothes)">
                            <option value="T-Shirts">T-Shirts</option>
                            <option value="Jersey">Jersey</option>
                            <option value="Hoodies">Hoodies</option>
                            <option value="Socks">Socks</option>
                        </optgroup>

                        <optgroup label="Crocs Specific">
                            <option value="Clogs">Classic Clogs</option>
                            <option value="Echo">Echo Collection</option>
                            <option value="Sandals">Sandals & Slides</option>
                        </optgroup>

                        <option value="NEW">+ Add New Category</option>
                    </select>
                    <input type="text" id="new-category-input" name="new_category" placeholder="Type Category Name..."
                        class="hidden w-full mt-2 bg-[#111] border border-[#F53003]/50 rounded-xl p-4 text-white italic focus:ring-0">
                </div>
            </div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="space-y-2">
        <label class="text-[11px] font-bold uppercase text-gray-500 tracking-wider">Color / Way</label>
        <input type="text" name="color" placeholder="e.g. Triple Black, Panda" required
            class="w-full bg-[#111] border border-white/10 rounded-xl p-4 text-white focus:border-[#F53003] outline-none transition-all">
    </div>

    <div class="space-y-2">
        <label class="text-[11px] font-bold uppercase text-gray-500 tracking-wider">Gender</label>
        <select name="gender" required
            class="w-full bg-[#111] border border-white/10 rounded-xl p-4 text-white focus:border-[#F53003] outline-none transition-all">
            <option value="Men">Men</option>
            <option value="Women">Women</option>
            <option value="Unisex">Unisex</option>
        </select>
    </div>

    <div class="space-y-2">
        <label class="text-[11px] font-bold uppercase text-gray-500 tracking-wider">Quality Grade</label>
        <select name="quality" required
            class="w-full bg-[#111] border border-white/10 rounded-xl p-4 text-white focus:border-[#F53003] outline-none transition-all">
            <option value="Top-Grade">Top-Grade</option>
            <option value="Class A">Class A</option>
            <option value="Slides">Slides</option>
        </select>
    </div>
</div>

            {{-- 4. PRICING, STOCK, SIZES --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase text-gray-500 tracking-wider">Price (PHP)</label>
                    <input type="number" name="price" placeholder="0.00" required
                        class="w-full bg-[#111] border border-white/10 rounded-xl p-4 text-white focus:border-[#F53003]">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase text-gray-500 tracking-wider">Stock</label>
                    <input type="number" name="quantity" placeholder="0" required
                        class="w-full bg-[#111] border border-white/10 rounded-xl p-4 text-white focus:border-[#F53003]">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase text-gray-500 tracking-wider">Available Sizes</label>
                    <input type="text" name="sizes" placeholder="7, 8, 9, 10 / S, M, L" required
                        class="w-full bg-[#111] border border-white/10 rounded-xl p-4 text-white focus:border-[#F53003]">
                </div>
            </div>

            {{-- 5. IMAGE UPLOAD --}}
            <div class="space-y-2">
                <label class="text-[11px] font-bold uppercase text-gray-500 tracking-wider">Product Image</label>
                <input type="file" name="image" id="image-upload" class="hidden" accept="image/*" onchange="previewImage(event)">
                <label for="image-upload" class="cursor-pointer block">
                    <div id="preview-container" class="w-full h-64 bg-[#111] border-2 border-dashed border-white/10 rounded-3xl flex flex-col items-center justify-center hover:bg-[#151515] transition-all overflow-hidden">
                        <div id="upload-placeholder" class="text-center">
                            <svg class="w-10 h-10 text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span class="text-[10px] font-bold uppercase text-gray-600 tracking-widest">Click to Upload</span>
                        </div>
                        <img id="image-preview" src="#" alt="Preview" class="hidden w-full h-full object-contain p-4">
                    </div>
                </label>
            </div>

            <button type="submit" class="w-full bg-[#F53003] py-6 rounded-2xl font-black uppercase text-xl text-white hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-[#F53003]/20">
                Save Product
            </button>
        </form>
    </div>

    <script>
        function autoSelectType(select) {
            const typeSelect = document.getElementById('type-select');
            const newCatInput = document.getElementById('new-category-input');

            // Show input if NEW is selected
            if (select.value === 'NEW') {
                newCatInput.classList.remove('hidden');
            } else {
                newCatInput.classList.add('hidden');
            }

            // Auto-sync Type based on Category
            const footwearCats = ['Basketball Shoes', 'Running Shoes', 'Lifestyle Sneakers', 'Jordan Brand', 'Clogs', 'Echo', 'Sandals'];
            const apparelCats = ['T-Shirts', 'Jersey', 'Hoodies', 'Socks'];

            if (footwearCats.includes(select.value)) {
                typeSelect.value = 'Footwear';
            } else if (apparelCats.includes(select.value)) {
                typeSelect.value = 'Apparel';
            }
        }

        function checkNewBrand(select) {
            const input = document.getElementById('new-brand-input');
            input.classList.toggle('hidden', select.value !== 'OTHER');
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('image-preview');
                const placeholder = document.getElementById('upload-placeholder');
                output.src = reader.result;
                output.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-admin-layout>
