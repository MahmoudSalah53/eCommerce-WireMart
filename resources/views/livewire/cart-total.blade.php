<div dir='ltr'>
<div class="cart-total">
    <span>@lang('messages.theTotal'): </span>
    <span>${{ number_format($total, 2) }}</span>
</div>
<button class="checkout-btn" wire:click="checkout">@lang('messages.completePurchase')</button>
</div>