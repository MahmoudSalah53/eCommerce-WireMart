@extends('layouts.app')
@section('title')
    WireMart
@endsection
@section('content')
<div class="modern-products-page" dir='ltr'>
    <!-- Hero Section -->
    <div class="products-hero">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-contentAll">
                <h1 class="hero-title">@lang('messages.explore')</h1>
                <p class="hero-subtitle">@lang('messages.exploreDescription')</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <livewire:product-search />
</div>

@section('scripts')
@endsection

<style>
    .search-icon {
        margin-top: 10px;
    }

    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid #eee;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
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
        background: rgba(255, 255, 255, 0.9);
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

    /* Search Box Styles */
    .search-box {
        position: relative;
    }

    .search-box .form-control {
        padding-left: 40px;
        border-radius: 25px;
        height: 45px;
        border: 1px solid #ddd;
        box-shadow: none;
    }

    .search-icon {
        position: absolute;
        left: 15px;
        top: 12px;
        color: #aaa;
    }

    /* Pagination Styles */
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 20px 0;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 8px 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s;
    }

    .pagination li.active span {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }

    .pagination li a:hover {
        background-color: #f1f1f1;
    }

    .pagination li.disabled span {
        color: #aaa;
        cursor: not-allowed;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes progress {
        0% {
            width: 0%;
        }

        100% {
            width: 100%;
        }
    }

    .animate-spin {
        animation: spin 1.2s cubic-bezier(0.5, 0.1, 0.5, 0.9) infinite;
    }

    .animate-progress {
        animation: progress 2s ease-in-out infinite;
    }

    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
</style>
@endsection