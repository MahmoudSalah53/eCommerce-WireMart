@extends('layouts.user')
@section('title')
    WireMart
@endsection
@section('content')

<div class="d-flex justify-content-center align-items-center" style="height: 60vh;">
    <div class="text-center">
        <h1 class="display-4 text-muted">🚧 @lang('messages.notAvailable') 🚧</h1>
        <p class="lead text-secondary mt-3">@lang('messages.noPage')</p>
    </div>
</div>

@endsection