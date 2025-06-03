@extends('admin.layouts.layout')
@section('admin_page_title')
Dashboard - Admin Panel
@endsection
@section('admin_layout')
<style>
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .dashboard-header h1 {
        font-size: 28px;
        color: #1A237E;
        font-weight: 700;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-profile img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
    }

    .stat-info h3 {
        font-size: 16px;
        color: #666;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        margin: 8px 0;
        font-family: 'Roboto Condensed', sans-serif;
    }

    .stat-change {
        font-size: 12px;
        color: #666;
    }

    .activity-container {
        display: grid;
        gap: 30px;
    }

    .activity-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .card-header h2 {
        font-size: 20px;
        color: #1A237E;
    }

    .view-all {
        color: #1976D2;
        text-decoration: none;
        font-weight: 500;
    }

    .activity-table {
        width: 100%;
        border-collapse: collapse;
    }

    .activity-table th {
        text-align: center;
        padding: 12px 15px;
        background-color: #f8f9fa;
        color: #555;
        font-weight: 600;
    }

    .activity-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    .activity-table tr:last-child td {
        border-bottom: none;
    }

    .status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .status.active {
        background: #E8F5E9;
        color: #2E7D32;
        width: 100%;
        text-align: center;
    }

    @media (max-width: 1200px) {
        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-container {
            grid-template-columns: 1fr;
        }

        .activity-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>
@livewireStyles
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
<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon" style="background: #4CAF50;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>@lang('messages.totalUsers')</h3>
            <p class="stat-number">{{ $user->count() }}</p>
            <p class="stat-change">{{ $weekPercentageUsers }} @lang('messages.fromLastMonth')</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #FF5722;">
            <i class="fas fa-boxes"></i>
        </div>
        <div class="stat-info">
            <h3>@lang('messages.totalProducts')</h3>
            <p class="stat-number">{{ $products->count() }}</p>
            <p class="stat-change">{{ $weekPercentageProducts }} @lang('messages.fromLastMonth')</p>
        </div>
    </div>
</div>

<div class="activity-container">

    <div class="activity-card">
        <div class="card-header">
            <h2>@lang('messages.latestSignups')</h2>
        </div>
        <table class="activity-table">
            <thead>
                <tr>
                    <th>@lang('messages.id')</th>
                    <th>@lang('messages.name')</th>
                    <th>@lang('messages.email')</th>
                    <th>@lang('messages.signupDate')</th>
                    <th>@lang('messages.role')</th>
                    <th>@lang('messages.action')</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($users as $user)
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        @if ($user->created_at->isToday())
                        Today, {{ $user->created_at->format('H:i') }}
                        @elseif ($user->created_at->isYesterday())
                        Yesterday, {{ $user->created_at->format('H:i') }}
                        @else
                        {{ $user->created_at->diffForHumans() }}, {{ $user->created_at->format('H:i') }}
                        @endif
                    </td>
                    <td>
                        @if($user->role === 0)
                        @lang('messages.admin')
                        @elseif($user->role === 1)
                        @lang('messages.seller')
                        @else
                        @lang('messages.customer')
                        @endif
                    </td>
                    <td class="d-flex" style="justify-content: center;">
                        @if($user->role === 1)
                            <form onsubmit="return confirm('Do you really want to make this Seller a Customer?')" action="{{route('updateUser.user', $user->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-primary mx-2" style="text-align: center;">@lang('messages.customer')</button>
                            </form>

                            <form onsubmit="return confirm('Do you really want to Delete this User?')" action="{{route('delete.user', $user->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onsubmit="return confirm('Do you really want to Delete this Seller?')" class="btn btn-danger" style="text-align: center;" onsubmit="return confirm('Do you really want to Delete this Seller?')">@lang('messages.delete')</button>
                            </form>
                        @elseif($user->role === 2)
                            <form onsubmit="return confirm('Do you really want to make this Customer a Seller?')" action="{{route('updateUser.user', $user->id)}}" method="POST"> 
                                @csrf
                                @method('PUT')
                                <button class="btn btn-primary mx-2" style="text-align: center;">@lang('messages.seller')</button>
                            </form>

                            <form onsubmit="return confirm('Do you really want to Delete this User?')" action="{{route('delete.user', $user->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" style="text-align: center;">@lang('messages.delete')</button>
                            </form>
                        @else
                        <p style="text-align: center;">-- --</p>
                        @endif
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="activity-card">
        <div class="card-header">
            <h2>@lang('messages.latestProducts')</h2>
        </div>
        <table class="activity-table">
            <thead>
                <tr>
                    <th>@lang('messages.id')</th>
                    <th>@lang('messages.name')</th>
                    <th>@lang('messages.category')</th>
                    <th>@lang('messages.price')</th>
                    <th>@lang('messages.stock')</th>
                    <th>@lang('messages.addedOnProduct')</th>
                    <th>@lang('messages.status')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->product_name}}</td>
                    <td>{{$product->category->category_name}}</td>
                    <td>{{$product->discounted_price ? $product->discounted_price : $product->regular_price}}</td>
                    <td>{{$product->stock_quantity}}</td>
                    <td>
                        @if ($product->created_at->isToday())
                        Today, {{ $product->created_at->format('H:i') }}
                        @elseif ($product->created_at->isYesterday())
                        Yesterday, {{ $product->created_at->format('H:i') }}
                        @else
                        {{ $product->created_at->diffForHumans() }}, {{ $product->created_at->format('H:i') }}
                        @endif
                    </td>
                    <td class="d-flex" style="justify-content: center;">
                        <livewire:activate-products :product="$product" :key="$product->id">
                            <form onsubmit="return confirm('Do you really want to Delete this Product?')" action="{{route('delete.product', $product->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger status">@lang('messages.delete')</button>
                            </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@livewireScripts
<script>
    Livewire.on('productActivated', () => {
        Toastify({
            text: "Product activated successfully!",
            duration: 3000,
            gravity: "bottom",
            position: "right",
            backgroundColor: "#4CAF50",
            close: true
        }).showToast();
    });
    Livewire.on('productDelete', () => {
        Toastify({
            text: "Product Deleted successfully!",
            duration: 3000,
            gravity: "bottom",
            position: "right",
            backgroundColor: "#4CAF50",
            close: true
        }).showToast();
    });
</script>

@endsection