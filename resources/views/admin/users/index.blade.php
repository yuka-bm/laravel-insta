@extends('layouts.app')

@section('title', 'Admin: Users')

@section('content')

    <form action="{{ route('admin.search') }}" style="width: 300px;" >
        @if (request()->is('admin/users/search*'))
            <input type="search" name="search" id="search" class="form-control form-control-sm" placeholder="Search..." value="{{ $search }}">
        @else
            <input type="search" name="search" id="search" class="form-control form-control-sm" placeholder="Search...">
        @endif
    </form>

    <table class="table table-hover align-middle bg-white border text-secondary mt-2">
        <thead class="small table-success text-secondary">
            <tr>
                <th></th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>CREATED_AT</th>
                <th>
                    <div class="d-flex">
                        STATUS
                        <a href="{{ route('admin.users.sort', isset($user_status) ? $user_status : 1) }}" class="ms-auto text-decoration-none">
                            @if (isset($user_status))
                                @if ($user_status == 1)
                                    <i class="fa-solid fa-caret-down fs-5 text-success"></i>
                                @else
                                    <i class="fa-solid fa-caret-up fs-5 text-success"></i>
                                @endif
                            @else
                                <i class="fa-solid fa-caret-down fs-5 text-dark"></i>
                            @endif
                        </a>
                    </div>
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_users as $user)
            <tr>
                <td>
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle d-block mx-auto avatar-md">
                    @else
                        <i class="fa-solid fa-circle-user d-block text-center icon-md">
                    @endif
                </td>
                <td>
                    @if ($user->trashed())
                        {{ $user->name }}
                    @else
                    <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none fw-bold text-dark">{{ $user->name }}</a>
                    @endif
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    @if ($user->trashed())
                        <i class="fa-regular fa-circle text-secondary"></i>&nbsp;Inactive
                    @else
                        <i class="fa-solid fa-circle text-success"></i>&nbsp; Active
                    @endif
                </td>
                <td>
                    @if (Auth::user()->id !== $user->id)
                        <div class="dropdown">
                            <button class="btn btn-sm" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>

                            <div class="dropdown-menu">
                                @if ($user->trashed())
                                    <button class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#activate-user-{{ $user->id }}">
                                        <i class="fa-solid fa-user-check"></i> Activate {{ $user->name }}
                                    </button>
                                @else
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{ $user->id }}">
                                        <i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}
                                    </button>
                                @endif
                            </div>
                        </div>
                        {{-- include modal --}}
                        @include('admin.users.modal.status')
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
    @if (request()->is('admin/users/search*'))
        {{ $all_users->appends(['search' => $search])->links() }}
    @else
        {{ $all_users->links() }}
    @endif
    </div>

@endsection
