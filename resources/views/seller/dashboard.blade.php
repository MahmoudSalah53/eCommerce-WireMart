@extends('seller.layouts.layout')
@section('seller_page_title')
Dashboard
@endsection
@section('seller_layout')
<style>
    .c1{
        background-color: #040453b3 !important;
    }
    .c2{
        background-color: #c79e08db !important;
    }
</style>
<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- Products Card -->
        <div class="col-xl-6 col-sm-6">
            <div class="card card-statistic shadow-lg animate-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 text-uppercase fw-semibold">@lang('messages.products')</p>
                            <h3 class="fw-bold mb-0 text-primary">
                                {{ $productsCount }}
                            </h3>
                            <div class="d-flex align-items-center mt-2">
                                <span class="badge bg-success-subtle text-success rounded-pill me-2">
                                    <i class="fas fa-arrow-{{ $percentageChange >= 0 ? 'up' : 'down' }} me-1"></i>
                                    {{ number_format($percentageChange, 2) }}%
                                </span>
                                <span class="text-xs text-muted">@lang('messages.lastMonth')</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 ms-3">
                            <div class="avatar-sm bg-primary bg-opacity-10 p-3 rounded-circle c1">
                                <i class="fas fa-box-open text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Annual Income Card -->
        <div class="col-xl-6 col-sm-6">
            <div class="card card-statistic shadow-lg animate-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 text-uppercase fw-semibold">@lang('messages.income')</p>
                            <h3 class="fw-bold mb-0 text-success">
                                ${{ number_format($annualIncome, 2) }}
                            </h3>
                            <div class="d-flex align-items-center mt-2">
                                <span class="badge bg-success-subtle text-success rounded-pill me-2">
                                    <i class="fas fa-arrow-{{ $incomePercentageChange >= 0 ? 'up' : 'down' }} me-1"></i>
                                    {{ number_format($incomePercentageChange, 2) }}%
                                </span>
                                <span class="text-xs text-muted">@lang('messages.lastMonth')</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 ms-3">
                            <div class="avatar-sm bg-success bg-opacity-10 p-3 rounded-circle c2">
                                <i class="fas fa-money-bill-wave text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-transparent border-0 p-4 pb-0">
                    <h5 class="mb-2 fw-semibold">@lang('messages.latestOrders')</h5>
                </div>
                <div class="card-body px-4 pt-0 pb-4">
                    <div class="table-responsive rounded-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs fw-semibold">@lang('messages.id')</th>
                                    <th class="text-uppercase text-secondary text-xs fw-semibold">@lang('messages.buyer')</th>
                                    <th class="text-uppercase text-secondary text-xs fw-semibold">@lang('messages.product')</th>
                                    <th class="text-uppercase text-secondary text-xs fw-semibold">@lang('messages.quantity')</th>
                                    <th class="text-uppercase text-secondary text-xs fw-semibold">@lang('messages.method')</th>
                                    <th class="text-uppercase text-secondary text-xs fw-semibold">@lang('messages.price')</th>
                                    <th class="text-uppercase text-secondary text-xs fw-semibold">@lang('messages.addedOn')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs fw-semibold mb-0">#{{ $order->id }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs fw-semibold mb-0">{{ $order->order->user->name }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs fw-semibold mb-0">{{ $order->product->product_name }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs fw-semibold mb-0">{{ $order->quantity }}</p>
                                    </td>
                                    <td>
                                        @if($order->order->payment_method == NULL)
                                            <p class="text-xs fw-semibold mb-0">mada</p>
                                        @else
                                            <p class="text-xs fw-semibold mb-0">{{ $order->order->payment_method }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-xs fw-semibold mb-0 text-success">${{ $order->price }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs fw-semibold mb-0">
                                            @if ($order->created_at->isToday())
                                            <span class="text-primary">Today</span>, {{ $order->created_at->format('H:i') }}
                                            @elseif ($order->created_at->isYesterday())
                                            <span class="text-secondary">Yesterday</span>, {{ $order->created_at->format('H:i') }}
                                            @else
                                            {{ $order->created_at->diffForHumans() }}, {{ $order->created_at->format('H:i') }}
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card-statistic {
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        background-color: #fff;
    }
    
    .card-statistic:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .animate-hover {
        transition: all 0.3s ease;
    }
    
    .animate-hover:hover {
        transform: scale(1.02);
    }
    
    .avatar-sm {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .table-hover tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
        transform: translateX(2px);
    }
    
    .rounded-3 {
        border-radius: 12px !important;
    }
    
    .bg-opacity-10 {
        opacity: 0.1;
    }
</style>
@endpush


@endsection