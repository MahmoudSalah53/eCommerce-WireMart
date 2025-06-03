@extends('layouts.app')
@section('title')
    WireMart
@endsection
@section('content')

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
@if(session('error'))
<script>
    Toastify({
        text: "{{ session('error') }}",
        duration: 5000,
        gravity: "bottom",
        position: "right",
        backgroundColor: "#f44336",
        close: true
    }).showToast();
</script>
@endif



<div class="product-display-container">
    <div class="product-header" dir="ltr">
        <h1 class="product-title">{{$product->product_name}}</h1>
        <div class="product-meta">
            <span class="sku">SKU: {{$product->sku}}</span>
            <span class="stock in-stock">
                @if($product->stock_quantity == 0)
                    @lang('messages.outOfStock')
                @else
                    @lang('messages.inStock')
                @endif
            </span>
            <span class="created-at">{{$product->created_at}}</span>
        </div>
    </div>

    <div class="product-content">

        <div class="product-details-section">
            <div class="price-section">
                <span class="discounted-price">${{$product->discounted_price}}</span>
                <span class="regular-price">${{$product->regular_price}}</span>
                <span class="discount-badge">Save {{ round((($product->regular_price - $product->discounted_price) / $product->regular_price * 100)) }}%</span>
            </div>

            <div class="product-description">
                <h3>@lang('messages.productDescription')</h3>
                <p>{{$product->description}}</p>
            </div>

            <div class="add-to-cart-section">
                <div class="add-to-cart-btn">
                    <livewire:add-to-cart-button :productId="$product->id" :key="'cart-btn-'.$product->id.'-'.now()->timestamp" />
                </div>
                <span class="stock-quantity ml-3 text-muted">@lang('messages.available'): {{$product->stock_quantity}}</span>
            </div>
        </div>


        <div class="product-image-section">
            <img src="{{asset('storage/' . $product->images->first()->img_path)}}"
                alt="{{$product->product_name}}"
                class="main-product-image">
        </div>
    </div>
</div>


@endsection