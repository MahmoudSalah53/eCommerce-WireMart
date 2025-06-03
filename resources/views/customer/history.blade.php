@extends('customer.layouts.layout')
@section('customer_page_title')
Order History
@endsection
@section('customer_layout')

<style>
    th,
    td {
        text-align: center;
    }
</style>

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
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@lang('messages.orderList')</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <livewire:order-history-customer />
            </div>
        </div>
    </div>
</div>

@endsection