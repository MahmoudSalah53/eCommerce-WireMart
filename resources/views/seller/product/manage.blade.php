@extends('seller.layouts.layout')
@section('seller_page_title')
    Manage Product
@endsection
@section('seller_layout')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('messages.allProducts')</h5>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alet alet-success">
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
                    </div>
                @endif

                @if($products->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('messages.id')</th>
                                <th>@lang('messages.name')</th>
                                <th>@lang('messages.quantity')</th>
                                <th>@lang('messages.price')</th>
                                <th>@lang('messages.status')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($products as $product)

                            <tr>
                                <td>{{$product->id}}</td>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->stock_quantity}}</td>
                                <td>{{$product->regular_price}}</td>
                                <td>
                                    @if($product->status == 'Draft')
                                        @lang('messages.unpublished')
                                    @else
                                        @lang('messages.published')
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{route('products.edit', $product->id)}}" class="btn btn-info me-2">@lang('messages.edit')</a>

                                        <form action="{{route('product.destroy', $product->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="@lang('messages.delete')" class="btn btn-danger">
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                @else
                <h1 class="text-center">@lang('messages.noFound')</h1>
                @endif
            </div>
            
        </div>
    </div>
</div>
@endsection