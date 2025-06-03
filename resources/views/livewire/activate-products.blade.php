<div class="d-flex">
    @if($products->status === 'Draft')
        <button class="btn btn-success status" wire:click="updateStatus">@lang('messages.activate')</button>
    @else
    <span class="status active my-1">@lang('messages.active')</span>
    @endif
</div>