<div>
<div class="container py-5">
    <!-- عنوان الصفحة مع عدد المنتجات -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">جميع المنتجات</h1>
        <span class="badge bg-primary">{{ $products->total() }} منتج</span>
    </div>

    <!-- فلترة المنتجات -->
    <div class="row mb-4">
        <div class="col-md-3">
            <select wire:model.lazy="sortBy" class="form-select">
                <option value="newest">الأحدث أولاً</option>
                <option value="price_asc">السعر: من الأقل للأعلى</option>
                <option value="price_desc">السعر: من الأعلى للأقل</option>
                <option value="popular">الأكثر مبيعاً</option>
            </select>
        </div>
        <div class="col-md-3">
            <select wire:model.lazy="category_id" class="form-select">
                <option value="">جميع الفئات</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <input wire:model.debounce.500ms="search" type="text" class="form-control" placeholder="ابحث عن منتج...">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- شبكة المنتجات -->
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-md-4 col-lg-3">
                <div class="card product-card h-100">
                    @if($product->discounted_price)
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                            خصم {{ round(($product->regular_price - $product->discounted_price) / $product->regular_price * 100) }}%
                        </span>
                    @endif

                    <div class="product-img-container">
                        <img src="{{ asset('storage/' . $product->images->first()->img_path) }}" class="card-img-top" alt="{{ $product->product_name }}">
                        <div class="product-actions">
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-heart"></i>
                            </button>
                            <button wire:click="addToCart({{ $product->id }})" class="btn btn-sm btn-primary">
                                <i class="fas fa-shopping-cart"></i> أضف للسلة
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($product->product_name, 40) }}</h5>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="text-primary fw-bold">{{ number_format($product->discounted_price ?: $product->regular_price) }} ج.م</span>
                                @if($product->discounted_price)
                                    <span class="text-muted text-decoration-line-through ms-2">{{ number_format($product->regular_price) }} ج.م</span>
                                @endif
                            </div>
                            <div class="rating">
                                <i class="fas fa-star text-warning"></i>
                                <small>4.5</small>
                            </div>
                        </div>
                        <div class="d-grid">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary">التفاصيل</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h3>لا توجد منتجات متاحة حالياً</h3>
                    <p class="mb-0">يمكنك تجربة البحث بكلمات أخرى أو تصفح فئات أخرى</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- الترقيم الصفحي -->
    @if($products->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
    @endif
</div>

@push('styles')
<style>
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid #eee;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .product-img-container {
        position: relative;
        overflow: hidden;
        height: 200px;
    }
    .product-img-container img {
        object-fit: cover;
        height: 100%;
        transition: transform 0.5s;
    }
    .product-card:hover .product-img-container img {
        transform: scale(1.05);
    }
    .product-actions {
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        background: rgba(255,255,255,0.9);
        padding: 10px;
        display: flex;
        justify-content: center;
        gap: 5px;
        transition: bottom 0.3s;
    }
    .product-card:hover .product-actions {
        bottom: 0;
    }
    .rating {
        background: #f8f9fa;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 0.8rem;
    }
</style>
@endpush
</div>
