<div class="na-card" data-tilt>
    <a href="{{ route('product.show', $product->slug) }}" class="na-card-link">
        <div class="na-card-img-wrap">
            @if($product->images && count($product->images) > 0)
                <img src="{{ (\Illuminate\Support\Str::startsWith($product->images[0]['path'], ['http://', 'https://']) ? $product->images[0]['path'] : Storage::url($product->images[0]['path'])) }}"
                    alt="{{ $product->name }}" class="na-card-img" loading="lazy"
                    onerror="this.onerror=null;this.src='https://placehold.co/300x360/101010/333333?text=No+Image';">
            @else
                <div class="na-card-img-placeholder">
                    <i class="ri-t-shirt-2-line"></i>
                </div>
            @endif

            {{-- Overlay --}}
            <div class="na-card-overlay">
                <span class="na-card-overlay-text">View Product</span>
            </div>

            {{-- New badge --}}
            <span class="na-card-badge">New</span>
        </div>

        <div class="na-card-body">
            <div class="na-card-name">{{ $product->name }}</div>
            <div class="na-card-price">
                @if($product->sale_price)
                    <span
                        style="text-decoration:line-through;font-size:0.7rem;color:#666;margin-right:4px;">${{ number_format($product->price, 0) }}</span>
                    ${{ number_format($product->sale_price, 0) }}
                @else
                    ${{ number_format($product->price, 0) }}
                @endif
            </div>
        </div>
    </a>
</div>