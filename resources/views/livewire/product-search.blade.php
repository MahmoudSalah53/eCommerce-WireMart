
<div class="container py-5">
    <!-- Search Bar -->
    <div class="products-filters mb-5">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="search-box">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="@lang('messages.productsSearch')"
                        wire:model.live.debounce.500ms="searchTerm">
                    <i class="fas fa-search search-icon"></i>
                    @if($searchTerm)
                    <button wire:click="clearSearch" class="btn btn-link clear-search">
                        <i class="fas fa-times"></i>
                    </button>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="results-count">
                        <span class="badge bg-primary rounded-pill">@lang('messages.productsCount'): {{ $products->total() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="products-grid">
        @forelse($products as $product)
        <div class="product-card-wrapper">
            <div class="product-card">
                <!-- Product Badges -->
                <div class="product-badges">
                    @if($product->stock_quantity === 0)
                    <span class="badge discount-badge">@lang('messages.outOfStock')</span>
                    @elseif($product->discounted_price)
                    <span class="badge discount-badge">@lang('messages.discount') {{ round((($product->regular_price - $product->discounted_price) / $product->regular_price * 100)) }}%</span>
                    @endif
                    @if($product->is_new)
                    <span class="badge new-badge">@lang('messages.new')</span>
                    @endif
                </div>

                <!-- Product Image -->
                <div class="product-image">
                    <img src="{{ asset('storage/' . $product->images->first()->img_path) }}" alt="{{ $product->product_name }}">
                </div>

                <!-- Product Info -->
                <div class="product-info">
                    <div class="product-category">{{ $product->category->category_name }}</div>
                    <h3 class="product-title for-eye">
                        <a href="">{{ Str::limit($product->product_name, 13) }}</a>
                        <form action="{{route('information.show', $product->id)}}" method="GET">
                            <button class="action-btn"><i class="fas fa-eye"></i></button>
                        </form>
                    </h3>

                    <!-- Price -->
                    <div class="product-price">
                        @if($product->discounted_price)
                        <span class="current-price">${{ number_format($product->discounted_price) }}</span>
                        <span class="old-price">${{ number_format($product->regular_price) }}</span>
                        @else
                        <span class="current-price">${{ number_format($product->regular_price) }}</span>
                        @endif
                    </div>

                    <!-- Add to Cart Button -->
                    <livewire:add-to-cart-button :productId="$product->id" :key="'cart-btn-'.$product->id.'-'.now()->timestamp" />
                </div>
            </div>
        </div>

        
        @empty
        <div class="empty-products">
            <div class="empty-content text-center py-5">
                <div class="empty-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3>@lang('messages.noProducts')</h3>
                <p class="text-muted">@lang('messages.differentKeywords')</p>
            </div>
        </div>
        @endforelse
    </div>



    <!-- Pagination -->
    <div dir='ltr' class="mt-4 d-flex justify-content-center">
        {{ $products->links(data: ['scrollTo' => false]) }}
    </div>
</div>