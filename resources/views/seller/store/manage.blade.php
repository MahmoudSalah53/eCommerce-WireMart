@extends('seller.layouts.layout')
@section('seller_page_title')
    Manage Store
@endsection
@section('seller_layout')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('messages.allStores')</h5>
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

                @if($stores->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('messages.id')</th>
                                <th>@lang('messages.name')</th>
                                <th>@lang('messages.slug')</th>
                                <th>@lang('messages.details')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($stores as $store)

                            <tr>
                                <td>{{$store->id}}</td>
                                <td>{{$store->store_name}}</td>
                                <td>{{$store->slug}}</td>
                                <td>{{$store->details}}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('store.edit', $store->id) }}" class="btn btn-info me-2">@lang('messages.edit')</a>

                                        <form action="{{ route('store.destroy', $store->id) }}" method="POST">
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