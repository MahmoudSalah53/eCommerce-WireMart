@extends('admin.layouts.layout')
@section('admin_page_title')
Manage Product Attributes - Admin Panel
@endsection
@section('admin_layout')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">All Default Attribute</h5>
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

                @if($allAttr->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Attribute</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($allAttr as $Attr)

                            <tr>
                                <td>{{$Attr->id}}</td>
                                <td>{{$Attr->attribute_value}}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('productattribute.edit', $Attr->id) }}" class="btn btn-info me-2">Edit</a>

                                        <form action="{{ route('productattribute.destroy', $Attr->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="Delete" class="btn btn-danger">
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                @else
                <h1 class="text-center">No Attribute Found!</h1>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection