@extends('admin.layouts.layout')
@section('admin_page_title')
Edit SubCategory - Admin Panel
@endsection
@section('admin_layout')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('messages.editSub')</h5>
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

                <form action="{{route('subcategory.update', $subcategory_info->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="subcategory_name" class="fw-bold mb-2">@lang('messages.subName')</label>
                    <input type="text" class="form-control" name="subcategory_name" value="{{$subcategory_info->subcategory_name}}">

                    <label for="category_id" class="fw-bold mb-2 my-2">@lang('messages.selectCate')</label>
                    <select name="category_id" class="form-control" id="Category_id">
                        @foreach($categories as $cat)
                            <option value="{{$cat->id}}" {{ $cat->id == $subcategory_info->category_id ? 'selected' : '' }}>
                                {{$cat->category_name}}
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
