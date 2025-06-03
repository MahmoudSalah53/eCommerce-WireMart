<div>
    @forelse($cartItems as $item)
    <div class="cart-item">
    <img src="{{ asset('storage/'.$item->product->images->first()->img_path) }}" 
         alt="{{ $item->product->name }}" width="60">
    
    <div class="item-details">
        <h5>{{ $item->product->product_name }}</h5>
        
        <div class="quantity-control">
            <button wire:click.debounce.100ms="decrement({{ $item->id }})">-</button>
            <span>{{ $item->quantity }}</span>
            <button wire:click.debounce.100ms="increment({{ $item->id }})">+</button>
        </div>
        
        <p>${{ $item->product->regular_price * $item->quantity }}</p>
    </div>
    
    <button wire:click.debounce.300ms="removeItem({{ $item->id }})" class="remove-btn">
        <i class="fas fa-trash"></i>
    </button>
</div>
    @empty
    <p>@lang('messages.emptyCart')</p>
    @endforelse
</div>