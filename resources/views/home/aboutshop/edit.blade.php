@extends('layouts.user')
@section('title')
    Edit About WireMart
@endsection
@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="display-4 text-dark mb-4 text-center">@lang('messages.editAbout')</h1>
            
            <form method="POST" action="{{ route('aboutshop.update') }}">
                @csrf
                @method('PUT')

                <!-- Who We Are Section -->
                <div class="form-group mb-4">
                    <label for="who_we_are" class="form-label">@lang('messages.WWR')</label>
                    <textarea name="who_we_are" id="who_we_are" class="form-control" rows="4">{{ config('about.who_we_are') }}</textarea>
                </div>

                <!-- Our Commitment Section -->
                <div class="form-group mb-4">
                    <label for="commitment_to_you" class="form-label">@lang('messages.commitment')</label>
                    <textarea name="commitment_to_you" id="commitment_to_you" class="form-control" rows="4">{{ config('about.commitment_to_you') }}</textarea>
                </div>

                <!-- Why Choose WireMart Section -->
                <div class="form-group mb-4">
                    <label for="why_choose_us" class="form-label">@lang('messages.WCU')</label>
                    <textarea name="why_choose_us" id="why_choose_us" class="form-control" rows="4">{{ implode("\n", config('about.why_choose_us')) }}</textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg">@lang('messages.saveChanges')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
