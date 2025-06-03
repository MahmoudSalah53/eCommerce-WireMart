@extends('admin.layouts.layout')
@section('admin_page_title')
Create Default Attributes - Admin Panel
@endsection
@section('admin_layout')
    <div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Create Default Attributes</h5>
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

                <form action="{{route('productattribute.store')}}" method="POST">
                    @csrf
                    <label for="attribute_value" class="fw-bold mb-2">Name of Attribute</label>
                    <input type="text" class="form-control" name="attribute_value" placeholder="XL">

                    <button type="submit" class="btn btn-primary w-100 mt-2">Add Attribute</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
