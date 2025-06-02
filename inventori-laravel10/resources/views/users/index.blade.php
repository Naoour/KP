@extends('layouts.app')

@section('content')
<style>
    .role-badge {
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 9999px; /* buat jadi pill shape */
        color: white;
        display: inline-block;
    }
    .role-user {
        background-color: #28a745; /* hijau */
    }
    .role-admin {
        background-color: #dc3545; /* merah */
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar User</h3>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah User Baru</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'user')
                            <span class="role-badge role-user">User</span>
                        @elseif($user->role === 'admin')
                            <span class="role-badge role-admin">Admin</span>
                        @else
                            {{ ucfirst($user->role ?? '-') }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
