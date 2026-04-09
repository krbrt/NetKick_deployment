<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netkicks Shop - Premium Footwear</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <x-app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-900">Shop All Products</h1>
                    <p class="mt-2 text-lg text-gray-600">Discover our latest collection of premium footwear.</p>
                </div>

                <!-- Filter Sidebar + Products Grid -->
                <div class="grid lg:grid-cols-4 gap-8">
                    <!-- Filters Sidebar -->
                    <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-6">Filters</h3>

                        @if(isset($filters))
                            @foreach($filters as $filterKey => $filter)
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-3 uppercase tracking-wide">
                                        {{ $filter['label'] ?? ucfirst($filterKey) }}
                                    </label>
                                    @if($filterKey === 'gender' || $filterKey === 'price')
                                        @foreach($filter['options'] as $option)
                                            <label class="flex items-center mb-2">
                                                <input type="checkbox" name="{{ $filterKey }}[]" value="{{ $option}}"
                                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 mr-2"
                                                       {{ in_array($option, (array) request($filterKey)) ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    @else
                                        @foreach(array_slice($filter['options'] ?? [], 0, 8) as $option)
                                            <label class="flex items-center mb-1">
                                                <input type="checkbox" name="{{ $filterKey }}[]" value="{{ $option }}"
                                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 mr-2 w-4 h-4"
                                                       {{ in_array($option, (array) request($filterKey)) ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-700 truncate">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        @endif

                        <button onclick="applyFilters()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            Apply Filters
                        </button>
                    </div>

                    <!-- Products Grid -->
                    <div class="lg:col-span-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @forelse($products as $product)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                    @if($product->is_on_sale)
                                        <div class="absolute top-3 left-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            Sale
                                        </div>
                                    @endif
                                    <div class="relative">
                                        <img src="{{ asset('images/products/' . $product->image) }}"
                                             alt="{{ $product->name }}" class="w-full h-64 object-cover">
                                    </div>
                                    <div class="p-6">
                                        <h3 class="font-semibold text-lg mb-2 line-clamp-2">{{ $product->name }}</h3>
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description ?? '', 80) }}</p>
                                        <div class="flex items-center justify-between">
                                            @if($product->is_on_sale && $product->sale_price)
                                                <div>
                                                    <span class="text-2xl font-bold text-green-600">₱{{ number_format($product->sale_price, 0) }}</span>
                                                    <span class="line-through text-gray-400 ml-2">₱{{ number_format($product->price, 0) }}</span>
                                                </div>
                                            @else
                                                <span class="text-2xl font-bold text-gray-900">₱{{ number_format($product->price, 0) }}</span>
                                            @endif
                                            <form action="{{ route('cart.store') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                                                    Add to Cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-12">
                                    <p class="text-gray-500 text-lg">No products found matching your filters.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function applyFilters() {
                // Serialize form data and reload
                const formData = new FormData();
                document.querySelectorAll('input[type=checkbox]:checked').forEach(cb => {
                    const name = cb.name.replace('[]', '');
                    formData.append(name, cb.value);
                });
                const params = new URLSearchParams(formData).toString();
                window.location.search = params ? '?' + params : '';
            }
        </script>
    </x-app-layout>
</body>
</html>
