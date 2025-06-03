@extends('seller.layouts.layout')
@section('seller_page_title')
Edit Product
@endsection
@section('seller_layout')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('messages.editProduct')</h5>
            </div>
            <div class="card-body">

                @if($errors->any())
                    @foreach($errors->all() as $error)
                    <script>
                        Toastify({
                            text: '{{$error}}',
                            duration: 5000,
                            gravity: "bottom", // من تحت
                            position: "right", // على اليمين
                            backgroundColor: "#4CAF50",
                            close: true
                        }).showToast();
                    </script>
                    @endforeach
                @endif

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label for="product_name" class="fw-bold mb-2">@lang('messages.name')</label>
                    <input type="text" class="form-control mb-2" name="product_name" value="{{ old('product_name', $product->product_name) }}" placeholder="Lenovo">

                    <label for="description" class="fw-bold mb-2">@lang('messages.description')</label>
                    <textarea name="description" class="form-control mb-2" id="description" cols="30" rows="10">{{ old('description', $product->description) }}</textarea>

                    <label for="images" class="fw-bold mb-2">@lang('messages.image')</label>
                    <input type="file" class="form-control mb-2" name="images[]" multiple>

                    <label for="sku" class="fw-bold mb-2">@lang('messages.sku')</label>
                    <input type="text" class="form-control mb-2" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="LXD3250">

                    <livewire:category_subcategory 
                        :selectedCategory="$product->category_id" 
                        :selectedSubcategory="$product->subcategory_id" 
                    />

                    <label for="store_id" class="fw-bold mb-2">@lang('messages.selectStore')</label>
                    <select name="store_id" id="store_id" class="form-control mb-2">
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}" {{ $product->store_id == $store->id ? 'selected' : '' }}>{{ $store->store_name }}</option>
                        @endforeach
                    </select>

                    <label for="regular_price" class="fw-bold mb-2">@lang('messages.regularPrice')</label>
                    <input type="number" class="form-control mb-2" name="regular_price" min='0' max='9999' value="{{ old('regular_price', $product->regular_price) }}">

                    <label for="discounted_price" class="fw-bold mb-2">@lang('messages.discountPrice')</label>
                    <input type="number" class="form-control mb-2" name="discounted_price" min='0' max='9999' value="{{ old('discounted_price', $product->discounted_price) }}">

                    <label for="tax_rate" class="fw-bold mb-2">@lang('messages.tax')</label>
                    <input type="number" class="form-control mb-2" name="tax_rate" min='0' max='1000' value="{{ old('tax_rate', $product->tax_rate) }}">

                    <label for="stock_quantity" class="fw-bold mb-2">@lang('messages.quantity')</label>
                    <input type="number" class="form-control mb-2" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}">

                    <label for="slug" class="fw-bold mb-2">@lang('messages.slug')</label>
                    <input type="text" class="form-control mb-2" name="slug" value="{{ old('slug', $product->slug) }}">

                    <label for="meta_title" class="fw-bold mb-2">@lang('messages.metaTitle')</label>
                    <input type="text" class="form-control mb-2" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}">

                    <label for="meta_description" class="fw-bold mb-2">@lang('messages.metaDescription')</label>
                    <input type="text" class="form-control mb-2" name="meta_description" value="{{ old('meta_description', $product->meta_description) }}">

                    <button type="submit" class="btn btn-primary w-100 mt-2">@lang('messages.update')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
