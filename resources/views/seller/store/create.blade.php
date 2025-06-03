@extends('seller.layouts.layout')
@section('seller_page_title')
    Create Store
@endsection
@section('seller_layout')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('messages.createStore')</h5>
            </div>
            <div class="card-body">

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

                <form action="{{route('store.store')}}" method="POST">
                    @csrf
                    <label for="store_name" class="fw-bold mb-2">@lang('messages.name')</label>
                    <input type="text" class="form-control" name="store_name" placeholder="Asib Store">

                    <label for="details" class="fw-bold mb-2">@lang('messages.description')</label>
                    <textarea name="details" id="details" cols="30" rows="10" class="form-control"></textarea>

                    <label for="slug" class="fw-bold mb-2">@lang('messages.slug')</label>
                    <input type="text" class="form-control" name="slug" placeholder="asib-store">

                    <button type="submit" class="btn btn-primary w-100 mt-2">@lang('messages.add')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection