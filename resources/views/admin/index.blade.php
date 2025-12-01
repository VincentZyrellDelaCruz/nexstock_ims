@extends('layouts.app')

@section('title', 'Admin Settings - NexStack')
@section('page-title', 'ADMIN SETTINGS')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.users.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Add User
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5>Users Management</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($user->role) }}</span></td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-success btn-sm">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

