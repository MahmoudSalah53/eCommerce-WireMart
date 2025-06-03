@extends('seller.layouts.layout')
@section('seller_page_title')
    Create Store
@endsection
@section('seller_layout')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('messages.editStore')</h5>
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

                <form action="{{route('store.update',$store_info->id )}}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="store_name" class="fw-bold mb-2">@lang('messages.name')</label>
                    <input type="text" class="form-control" name="store_name" value="{{$store_info->store_name}}">

                    <label for="details" class="fw-bold mb-2">@lang('messages.description')</label>
                    <textarea name="details" id="details" cols="30" rows="10" class="form-control">{{$store_info->details}}</textarea>

                    <label for="slug" class="fw-bold mb-2">@lang('messages.slug')</label>
                    <input type="text" class="form-control" name="slug" value="{{$store_info->slug}}" ">

                    <button type="submit" class="btn btn-primary w-100 mt-2">@lang('messages.update')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection