@extends('layouts.user')
@section('title')
WireMart
@endsection
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <!-- Edit Button (Admin Only) -->
            @if(Auth::user() && Auth::user()->role == 0)
            <div class="edit-btn-container">
                <a href="{{ route('aboutshop.edit') }}" class="btn btn-warning btn-lg rounded-circle shadow"
                    style="width: 60px; height: 60px; padding: 0; line-height: 60px;">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            </div>
            @endif

            <!-- Page Header -->
            <div class="about-header text-center">
                <h1 class="display-4 mb-4" style="font-weight: 700; color: #2c3e50;">@lang('messages.aboutWire')</h1>
                <p class="lead mb-0" style="font-size: 1.3rem; color: #5a5a5a;">
                    Your trusted destination for cutting-edge electronics and exceptional shopping experience
                </p>
            </div>

            <!-- About Content Sections -->
            <div class="about-card">
                <h3 class="section-title center">@lang('messages.WWR')</h3>
                <p class="text-dark text-center" style="font-size: 1.1rem; line-height: 1.8;">
                    {{ config('about.who_we_are') }}
                </p>
            </div>

            <div class="about-card">
                <h3 class="section-title center">@lang('messages.commitment')</h3>
                <p class="text-dark text-center" style="font-size: 1.1rem; line-height: 1.8;">
                    {{ config('about.commitment_to_you') }}
                </p>
            </div>

            <div class="about-card">
                <h3 class="section-title center">@lang('messages.WCU')</h3>
                <div class="px-4">
                    @foreach(config('about.why_choose_us') as $item)
                    <div class="feature-item">{{ $item }}</div>
                    @endforeach
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-5">
                <p class="mb-4" style="font-size: 1.15rem; color: #6c757d;">
                    @lang('messages.alwaysUpdated')
                </p>
                <a href="{{ route('all.products') }}" class="btn btn-explore shadow">
                    <i class="fas fa-chevron-right ml-2"></i>  @lang('messages.exploreProducts') 
                </a>
            </div>
        </div>
    </div>
</div>
@endsection