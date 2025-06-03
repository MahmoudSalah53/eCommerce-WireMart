@extends('seller.layouts.layout')
@section('seller_page_title', 'Your Profile')

@section('seller_layout')

@error('current_password')
    <script>
        Toastify({
            text: '{{$message}}',
            duration: 5000,
            gravity: "bottom",
            position: "right",
            backgroundColor: "#4CAF50",
            close: true
        }).showToast();
    </script>
@enderror

@if($errors->any())
    @foreach($errors->all() as $error)
    <script>
        Toastify({
            text: '{{$error}}',
            duration: 5000,
            gravity: "bottom",
            position: "right",
            backgroundColor: "#4CAF50",
            close: true
        }).showToast();
    </script>
    @endforeach
@endif

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

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <div class="row">
                        <div class="col-md-4 text-center" style=" width: 400px;">
                            @if($user->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $user->images->first()->img_path) }}" alt="profile_image" style=" width: 100%; height: 100%;">
                            @else
                            <img src="{{ asset('assets/img/default-avatar.png') }}" alt="profile_image" class=" border-radius-lg shadow-sm">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">@lang('messages.fullName')</th>
                                            <td class="text-sm">{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">@lang('messages.emailProfile')</th>
                                            <td class="text-sm">{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">@lang('messages.createdAtProfile')</th>
                                            <td class="text-sm">{{ $user->created_at->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">@lang('messages.profileRole')</th>
                                            <td class="text-sm">
                                                <span>
                                                    @if($user->role == 0)
                                                        @lang('messages.adminProfile')
                                                    @elseif($user->role == 1)
                                                        @lang('messages.sellerProfile')
                                                    @else
                                                        @lang('messages.customerProfile')
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 d-flex">
                                <button class="btn btn-primary mx-1" onclick="openEditModal()">@lang('messages.editProfile')</button>
                                <button class="btn btn-outline-secondary mx-1" onclick="openPassModal()">@lang('messages.editPass')</button>
                                <form action="{{route('delete.seller')}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger mx-1" onclick="return confirm('Your data will be Deleted. Are you sure?')">@lang('messages.deleteAccount')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Overlay -->
<div id="editProfileModal" class="modal-overlay">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('messages.editProfile')</h5>
                <button type="button" class="close-btn" onclick="closeEditModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('vendor.profileupdate', $user->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">@lang('messages.fullName')</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">@lang('messages.emailProfile')</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="fw-bold mb-2">@lang('messages.imageProfile')</label>
                        <input type="file" class="form-control mb-2" name="images[]" multiple>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">@lang('messages.cancel')</button>
                        <button type="submit" class="btn btn-primary">@lang('messages.saveChanges')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editPasswordModal" class="modal-overlay">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('messages.editPass')</h5>
                <button type="button" class="close-btn" onclick="closePassModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('vendor.passwordupdate', $user->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="current_password" class="form-label">@lang('messages.currPass')</label>
                        <div class="input-group">
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                <i class="fas fa-eye" style="color: black;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="new_password" class="form-label">@lang('messages.newPass')</label>
                        <div class="input-group">
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="new_password_confirmation" class="form-label">@lang('messages.reNewPass')</label>
                        <div class="input-group">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password_confirmation">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closePassModal()">@lang('messages.cancel')</button>
                        <button type="submit" class="btn btn-primary">@lang('messages.updatePass')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .modal-dialog {
        width: 100%;
        max-width: 900px;
    }

    .modal-content {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        pointer-events: auto;
        text-align: start !important;
    }

    .modal-header {
        padding: 16px 24px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        margin: 0;
        font-size: 1.25rem;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6c757d;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }
</style>

<script>
    function openEditModal() {
        document.getElementById('editProfileModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('editProfileModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function openPassModal() {
        document.getElementById('editPasswordModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closePassModal() {
        document.getElementById('editPasswordModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // إغلاق الـ modal عند النقر خارج المحتوى
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    });

    // تفعيل إظهار/إخفاء كلمة المرور
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>
@endsection