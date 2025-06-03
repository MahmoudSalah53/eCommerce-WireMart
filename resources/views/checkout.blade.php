@extends('layouts.app')

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
@if($cartItems->isEmpty())
<h1 class="checkout-container">@lang('messages.noItems')</h1>
@else
<div class="checkout-container" dir='ltr'>
    <h1>@lang('messages.payment')</h1>

    <div class="order-summary">
        @foreach($cartItems as $item)
        <div class="order-item">
            <img src="{{ asset('storage/' . $item->product->images->first()->img_path) }}"
                alt="{{ $item->product->product_name }}">
            <div class="item-info">
                <h3>{{ $item->product->product_name }}</h3>
                <p>@lang('messages.quantity'): {{ $item->quantity }}</p>
                <p>@lang('messages.price'): ${{ number_format($item->product->regular_price * $item->quantity, 2) }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="payment-methods">
            <h2>@lang('messages.selectPaymentMethod')</h2>

            <label>
                <input type="radio" name="payment_method" value="credit_card" required>
                <span>@lang('messages.creditCard')</span>
            </label>

            <label>
                <input type="radio" name="payment_method" value="mada" required>
                <span>@lang('messages.mada')</span>
            </label>

            <label>
                <input type="radio" name="payment_method" value="paypal" required>
                <span>@lang('messages.paypal')</span>
                <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" alt="PayPal Logo">
            </label>
        </div>
        <button type="submit" class="confirm-payment-btn">
            @lang('messages.confirmPayment')
        </button>
    </form>
</div>

@endif
@endsection