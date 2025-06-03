<div>
    <!-- Search Bar -->
    <div class="mb-4">
        <div class="input-group">
            <input wire:model.live.debounce.500ms='searchTerm' type="text" class="form-control" placeholder="@lang('messages.productsSearch')">
        </div>
    </div>
    <table class="table table-bordered" id="productsTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>@lang('messages.id')</th>
                <th>@lang('messages.name')</th>
                <th>@lang('messages.email')</th>
                <th>@lang('messages.signupDate')</th>
                <th>@lang('messages.role')</th>
                <th>@lang('messages.action')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->created_at->isToday())
                        Today, {{ $user->created_at->format('H:i') }}
                    @elseif ($user->created_at->isYesterday())
                        Yesterday, {{ $user->created_at->format('H:i') }}
                    @else
                        {{ $user->created_at->diffForHumans() }}, {{ $user->created_at->format('H:i') }}
                    @endif
                </td>
                <td>
                    @if($user->role === 0)
                        @lang('messages.admin')
                    @elseif($user->role === 1)
                        @lang('messages.seller')
                    @else
                        @lang('messages.customer')
                    @endif
                </td>
                <td class="d-flex" style="justify-content: center;">
                    @if($user->role === 1)
                    <form onsubmit="return confirm('Do you really want to make this Seller a Customer?')" action="{{route('updateUser.user', $user->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-primary mx-2" style="text-align: center;">@lang('messages.customer')</button>
                    </form>

                    <form onsubmit="return confirm('Do you really want to Delete this User?')" action="{{route('delete.user', $user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onsubmit="return confirm('Do you really want to Delete this Seller?')" class="btn btn-danger" style="text-align: center;" onsubmit="return confirm('Do you really want to Delete this Seller?')">@lang('messages.delete')</button>
                    </form>
                    @elseif($user->role === 2)
                    <form onsubmit="return confirm('Do you really want to make this Customer a Seller?')" action="{{route('updateUser.user', $user->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-primary mx-2" style="text-align: center;">@lang('messages.seller')</button>
                    </form>

                    <form onsubmit="return confirm('Do you really want to Delete this User?')" action="{{route('delete.user', $user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" style="text-align: center;">@lang('messages.delete')</button>
                    </form>
                    @else
                    <p style="text-align: center;">-- --</p>
                    @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    <div dir='ltr' class="mt-4 d-flex justify-content-center">
        {{ $users->links(data: ['scrollTo' => false]) }}
    </div>
</div>