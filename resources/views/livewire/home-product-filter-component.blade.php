<div>
@if($errors->any())
    @foreach($errors->all() as $error)
    <script>
        Toastify({
            text: '{{$error}}',
            duration: 5000,
            gravity: "bottom",
            position: "right",
            backgroundColor: "#4CAF50",
            close: true
        }).showToast();
    </script>
    @endforeach
@endif

@if(session('success'))
    <script>
        Toastify({
            text: "{{session('success')}}",
            duration: 5000,
            gravity: "bottom",
            position: "right",
            backgroundColor: "#8BC34A",
            close: true
        }).showToast();
    </script>
@endif

<section class="featured-categories">
    <div class="section-title" dir='ltr'>
        <h2>@lang('messages.browesByCategories')</h2>
    </div>
    <div class="categories-container">
        @foreach($categories as $category)
            <button
                wire:click="filterByCategory({{ $category->id }})"
                wire:key="category-btn-{{ $category->id }}"
                class="category-btn {{ $selectedCategory === $category->id ? 'hot' : '' }}">
                {{ $category->category_name }}
            </button>
        @endforeach
        <button
            wire:click="filterByCategory(null)"
            wire:key="all-products-btn"
            class="all-products-premium">
            <span class="ap-icon">📦</span>
            <span class="ap-text">@lang('messages.allProducts')</span>
        </button>
    </div>
</section>

@if($products->isEmpty())
<div class="modern-empty-state">
    <div class="empty-state-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#4a6bff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
    </div>
    <h3 class="empty-state-title">@lang('messages.noCate')</h3>
    <p class="empty-state-text">@lang('messages.workingOnCate')</p>
    <div class="empty-state-wave">
        <svg viewBox="0 0 500 20" preserveAspectRatio="none">
            <path d="M0,10 C150,18 350,2 500,10 L500,20 L0,20 Z" fill="#f8fafc"></path>
        </svg>
    </div>
</div>
@else

@auth
<section class="trending-products">
    <div class="section-title">
        @if($selectedCategory)
            <a href="{{ route('all.products', ['category_id' => $selectedCategory]) }}" class="view-all">
            @lang('messages.viewAll') <i class="fas fa-chevron-left"></i>
            </a>
        @else
            <a href="{{ route('all.products') }}" class="view-all">
            @lang('messages.viewAll') <i class="fas fa-chevron-left"></i>
            </a>
        @endif
        <h2>@lang('messages.trendProd')</h2>
    </div>
    <div class="products-container">
        @foreach($products as $product)
        <div class="product-card" wire:key="product-{{ $product->id }}-{{ now()->timestamp }}" data-id="{{ $product->id }}" data-name="{{ $product->product_name }}" data-price="{{ $product->regular_price }}">
            @if($product->discounted_price)
                <span class="product-badge sale">@lang('messages.discount')</span>
            @endif

            @if($product->stock_quantity === 0)
                <span class="product-badge sale">@lang('messages.outOfStock')</span>
            @endif

            <div class="product-image">
                <img src="{{'storage/' . $product->images->first()->img_path}}" alt="{{ $product->product_name }}">
                <div class="product-actions" style="display: flex">
                    <livewire:add-to-cart-button :productId="$product->id" :key="'cart-btn-'.$product->id.'-'.$renderKey" />
                    <form action="{{route('information.show', $product->id)}}" method="GET">
                        <button class="action-btn wishlist-btn"><i class="fas fa-eye"></i></button>
                    </form>
                </div>
            </div>
            <div class="product-info">
                <div class="product-category">{{ $product->category->category_name ?? 'General' }}</div>
                <h3 class="product-title">{{ $product->product_name }}</h3>
                <div class="product-price">
                    @if($product->discounted_price)
                    <span class="price">${{ $product->discounted_price }}</span>
                        <span class="old-price">${{ $product->regular_price }}</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endauth

@guest
<section class="trending-products">
    <div class="section-title">
        <a href="{{ route('all.products') }}" class="view-all">@lang('messages.viewAll') <i class="fas fa-chevron-left"></i></a>
        <h2>Trending Products</h2>
    </div>
    <div class="products-container">
        @foreach($products as $product)
        <div class="product-card" wire:key="product-{{ $product->id }}-{{ now()->timestamp }}" data-id="{{ $product->id }}" data-name="{{ $product->product_name }}" data-price="{{ $product->regular_price }}">
            @if($product->discounted_price)
                <span class="product-badge sale">@lang('messages.discount')</span>
            @endif

            <div class="product-image">
                <img src="{{ 'storage/' . $product->images->first()->img_path }}" alt="{{ $product->product_name }}">
                <div class="product-actions">
                    <livewire:add-to-cart-button :productId="$product->id" :key="'cart-btn-'.$product->id.'-'.$renderKey" />
                    <form action="{{route('information.show', $product->id)}}" method="GET">
                        <button class="action-btn wishlist-btn"><i class="fas fa-eye"></i></button>
                    </form>
                </div>
            </div>
            <div class="product-info">
                <div class="product-category">{{ $product->category->name ?? 'General' }}</div>
                <h3 class="product-title">{{ $product->product_name }}</h3>
                <div class="product-price">
                    @if($product->discounted_price)
                    <span class="price">${{ $product->discounted_price }}</span>
                        <span class="old-price">${{ $product->regular_price }}</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endguest
@endif
</div>
