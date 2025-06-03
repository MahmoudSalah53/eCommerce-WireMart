<div>
    <!-- Search Bar -->
    <div class="mb-4">
            <div class="input-group">
                <input wire:model.live.debounce.500ms='searchTerm' type="text" class="form-control" placeholder="@lang('messages.productsSearch')">
            </div>
    </div>
    <table class="table table-bordered" id="productsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>@lang('messages.id')</th>
                            <th>@lang('messages.product')</th>
                            <th>@lang('messages.quantity')</th>
                            <th>@lang('messages.method')</th>
                            <th>@lang('messages.price')</th>
                            <th>@lang('messages.addedOn')</th>
                        </tr>
                    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->product->product_name }}</td>
            <td>{{ $order->quantity }}</td>
            <td>
                @if($order->order->payment_method == NULL)
                    mada
                @else
                    {{ $order->order->payment_method }}
                @endif
            </td>
            <td>${{ $order->price }}</td>
            <td>
                @if ($order->created_at->isToday())
                Today, {{ $order->created_at->format('H:i') }}
                @elseif ($order->created_at->isYesterday())
                Yesterday, {{ $order->created_at->format('H:i') }}
                @else
                {{ $order->created_at->diffForHumans() }}, {{ $order->created_at->format('H:i') }}
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
    <div dir='ltr' class="mt-4 d-flex justify-content-center">
        {{ $orders->links(data: ['scrollTo' => false]) }}
    </div>
</div>