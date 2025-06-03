@extends('admin.layouts.layout')
@section('admin_page_title')
Create Category - Admin Panel
@endsection
@section('admin_layout')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('messages.createCategory')</h5>
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
                <form action="{{route('store.cat')}}" method="POST">
                    @csrf
                    <label for="category_name" class="fw-bold mb-2">@lang('messages.categoryName')</label>
                    <input type="text" class="form-control" name="category_name" placeholder="Computer">

                    <button type="submit" class="btn btn-primary w-100 mt-2">@lang('messages.add')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection