<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($products as $product)
        <div class="product-card">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
            <h4>{{ $product->name }}</h4>
            <p>₱{{ number_format($product->price, 2) }}</p>
        </div>
    @endforeach
</div>