@extends('admin.layouts.layout')
@section('admin_page_title')
Manage Category - Admin Panel
@endsection
@section('admin_layout')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('messages.allCategories')</h5>
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

                @if($categories->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('messages.id')</th>
                                <th>@lang('messages.name')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($categories as $cat)

                            <tr>
                                <td>{{$cat->id}}</td>
                                <td>{{$cat->category_name}}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('show.cat', $cat->id) }}" class="btn btn-info me-2">@lang('messages.edit')</a>

                                        <form action="{{ route('category.destroy', $cat->id) }}" method="POST">
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
                <h1 class="text-center">@lang('messages.noCate')</h1>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection