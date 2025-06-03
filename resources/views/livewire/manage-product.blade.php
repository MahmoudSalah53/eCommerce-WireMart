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
                            <th>@lang('messages.image')</th>
                            <th>@lang('messages.name')</th>
                            <th>@lang('messages.category') - @lang('messages.subCategory')</th>
                            <th>@lang('messages.price')</th>
                            <th>@lang('messages.stock')</th>
                            <th>@lang('messages.addedOn')</th>
                            <th>@lang('messages.action')</th>
                        </tr>
                    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>
                @if($product->images)
                <img src="{{ asset('storage/'.$product->images->first()->img_path) }}" alt="{{ $product->product_name }}" width="50">
                @else
                <img src="https://via.placeholder.com/50" alt="No Image" width="50">
                @endif
            </td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->category->category_name ?? 'Uncategorized' }} || {{ $product->subcategory->subcategory_name ?? 'Unsubcategorized' }}</td>
            <td>${{ number_format($product->discounted_price, 2) }}</td>
            <td>{{ $product->stock_quantity }}</td>
            <td>
                @if ($product->created_at->isToday())
                Today, {{ $product->created_at->format('H:i') }}
                @elseif ($product->created_at->isYesterday())
                Yesterday, {{ $product->created_at->format('H:i') }}
                @else
                {{ $product->created_at->diffForHumans() }}, {{ $product->created_at->format('H:i') }}
                @endif
            </td>
            <td>
                <div class="btn-group" role="group">

                    <livewire:activate-products :product="$product" :key="$product->id . now()->timestamp">

                        <form action="{{route('productAdmin.destroy', $product->id)}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mx-2" onclick="return confirm('Are you sure you want to delete this product?')">
                                @lang('messages.delete')
                            </button>
                        </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
    <div dir='ltr' class="mt-4 d-flex justify-content-center">
        {{ $products->links(data: ['scrollTo' => false]) }}
    </div>
</div>