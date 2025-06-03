@extends('admin.layouts.layout')
@section('admin_page_title')
Settings - Admin Panel
@endsection
@section('admin_layout')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('messages.settings')</h5>
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

                <form action="{{route('admin.homepagesetting.update')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="discounted_product_id" class="fw-bold mb-2">@lang('messages.seleteDiscountProduct')</label>
                    <select name="discounted_product_id" id="discounted_product_id" class="form-control">
                        @foreach($products as $product)    
                            <option value="{{$product->id}}" {{$homepagesetting->discounted_product_id == $product->id ?
                                'selected': ''}}>
                                {{$product->product_name}}
                            </option>
                        @endforeach
                    </select>
                    
                    <label for="discount_percent" class="fw-bold mb-2 my-2">@lang('messages.discountPercent')</label>
                    <input type="number" value="{{$homepagesetting->discount_percent}}" class="form-control"
                    name="discount_percent">

                    <label for="discount_heading" class="fw-bold mb-2 my-2">@lang('messages.discountHeading')</label>
                    <input type="text" class="form-control" value="{{$homepagesetting->discount_heading}}" 
                    name="discount_heading">

                    <label for="discount_subheading" class="fw-bold mb-2 my-2">@lang('messages.discountSubText')</label>
                    <input type="text" class="form-control" value="{{$homepagesetting->discount_subheading}}"
                    name="discount_subheading">
                    
                    <label for="featured_product_1_id" class="fw-bold mb-2 my-2">@lang('messages.selectFeature1')</label>
                    <select name="featured_product_1_id" id="featured_product_1_id" class="form-control">
                        @foreach($products as $product)    
                            <option value="{{$product->id}}" {{$homepagesetting->featured_product_1_id == $product->id ?
                                'selected': ''}}>
                                {{$product->product_name}}
                            </option>
                        @endforeach
                    </select>

                    <label for="featured_product_2_id" class="fw-bold mb-2 my-2">@lang('messages.selectFeature2')</label>
                    <select name="featured_product_2_id" id="featured_product_2_id" class="form-control">
                        @foreach($products as $product)    
                            <option value="{{$product->id}}" {{$homepagesetting->featured_product_2_id == $product->id ?
                                'selected': ''}}>
                                {{$product->product_name}}
                            </option>
                        @endforeach
                    </select>


                    <button type="submit" class="btn btn-primary w-100 mt-2">@lang('messages.update')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection