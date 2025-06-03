<div>
    <label for="category_id" class="fw-bold mb-2">@lang('messages.selectCate')</label>
    <select class="form-control mb-2" name="category_id" wire:model.live='selectedCategory'>
        @foreach($categories as $category)
        <option value="{{$category->id}}" {{ $category->id == $selectedCategory ? 'selected' : '' }}>
            {{$category->category_name}}
        </option>
        @endforeach
    </select>

    <label for="subcategory_id" class="fw-bold mb-2">@lang('messages.selectSub')</label>
    <select class="form-control mb-2" name="subcategory_id" wire:model.live='selectedSubcategory'>
        @foreach($subcategories as $subcategory)
        <option value="{{$subcategory->id}}" {{ $subcategory->id == $selectedSubcategory ? 'selected' : '' }}>
            {{$subcategory->subcategory_name}}
        </option>
        @endforeach
    </select>
</div>
