@extends('layouts.user')
@section('title')
    WireMart
@endsection
@section('content')
    <section class="modern-hero">
        <div class="hero-container">


            <div class="side-products">
                <div class="side-product top-product">
                    <img src="{{ 
        asset(
            'storage/' .
            (optional($homepagesetting)->featuredProduct2 && optional($homepagesetting->featuredProduct2->images)->first()
                ? $homepagesetting->featuredProduct2->images->first()->img_path
                : 'path/to/default/image.jpg')
        )
    }}" alt="{{optional($homepagesetting)->featuredProduct2 && optional($homepagesetting->featuredProduct2->images)->first()
        ? 'offers' : 'Wait for the admin to change it'}}" class="side-image">
                    <div class="side-info">
                        <h3>{{$homepagesetting->featuredProduct1->product_name ?? 'No Found'}}</h3>
                        <p class="side-price">
                            ${{ optional(optional($homepagesetting)->featuredProduct1)->discounted_price ?? 'No Found'}}</p>
                        <span class="old-price">${{ $homepagesetting->featuredProduct1->regular_price ?? 'No Found'}}</span>
                    </div>
                </div>

                <div class="side-product bottom-product">
                    <div class="side-info">
                        <h3>{{$homepagesetting->featuredProduct2->product_name ?? 'No Found'}}</h3>
                        <p class="side-price">
                            ${{ optional(optional($homepagesetting)->featuredProduct2)->discounted_price ?? 'No Found'}}</p>
                        <span class="old-price">${{ $homepagesetting->featuredProduct2->regular_price ?? 'No Found'}}</span>
                    </div>
                    <img src="{{ 
        asset(
            'storage/' .
            (optional($homepagesetting)->featuredProduct1 && optional($homepagesetting->featuredProduct1->images)->first()
                ? $homepagesetting->featuredProduct1->images->first()->img_path
                : 'path/to/default/image.jpg')
        ) 
    }}" alt="{{optional($homepagesetting)->featuredProduct1 && optional($homepagesetting->featuredProduct1->images)->first()
        ? 'offers' : 'Wait for the admin to change it'}}" class="side-image">
                </div>
            </div>
            <div class="main-hero" dir='ltr'>
                <div class="hero-content">
                    <img src="{{ 
        asset(
            'storage/' .
            (optional($homepagesetting)->discountedProduct && optional($homepagesetting->discountedProduct->images)->first()
                ? $homepagesetting->discountedProduct->images->first()->img_path
                : 'path/to/default/image.jpg')
        ) 
    }}" alt="{{optional($homepagesetting)->discountedProduct && optional($homepagesetting->discountedProduct->images)->first()
        ? 'offers' : 'Wait for the admin to change it'}}" class="hero-main-image">
                    <div class="hero-text">
                        <span class="discount-tag">@lang('messages.discount')
                            {{$homepagesetting->discount_percent ?? 'No Found'}}%</span>
                        <h1>{{$homepagesetting->discount_heading ?? 'No Found'}}</h1>
                        <p>{{$homepagesetting->discount_subheading ?? 'No Found'}}</p>
                        @if($homepagesetting && $homepagesetting->discountedProduct)
                            <form action="{{ route('information.show', $homepagesetting->discountedProduct->id) }}"
                                method="GET">
                                <button class="hero-button">@lang('messages.shopNow')</button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>

    <livewire:HomeProductFilterComponent />


    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

@endsection