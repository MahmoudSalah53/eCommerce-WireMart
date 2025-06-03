@extends('admin.layouts.layout')
@section('admin_page_title')
Create SubCategory - Admin Panel
@endsection
@section('admin_layout')
    <div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('messages.createSubCate')</h5>
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

                <form action="{{route('subcategories.store')}}" method="POST">
                    @csrf
                    <label for="subcategory_name" class="fw-bold mb-2">@lang('messages.subName')</label>
                    <input type="text" class="form-control" name="subcategory_name" placeholder="Computer">

                    <label for="category_id" class="fw-bold mb-2 my-2">@lang('messages.selectCate')</label>
                    <select name="category_id" class="form-control" id="Category_id">
                        @foreach($categories as $cat)
                            <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary w-100 mt-2">@lang('messages.add')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection