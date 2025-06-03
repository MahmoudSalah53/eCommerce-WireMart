@extends('admin.layouts.layout')
@section('admin_page_title')
Manage Sub Category - Admin Panel
@endsection
@section('admin_layout')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('messages.allSub')</h5>
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

                @if($subcategories->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('messages.id')</th>
                                <th>@lang('messages.name')</th>
                                <th>@lang('messages.categoryName')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($subcategories->isEmpty())
                                <h1>@lang('messages.noFound')</h1>
                            @else
                            @foreach($subcategories as $subcat)

                            <tr>
                                <td>{{$subcat->id}}</td>
                                <td>{{$subcat->subcategory_name}}</td>
                                <td>{{$subcat->category->category_name ?? '-- --'}}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('subcategories.show', $subcat->id) }}" class="btn btn-info me-2">@lang('messages.edit')</a>

                                        <form action="{{ route('subcategories.destroy', $subcat->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="@lang('messages.delete')" class="btn btn-danger">
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                        @endforeach
                        @endif
                    </table>
                </div>
                @else
                <h1 class="text-center">@lang('messages.noSub')</h1>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection