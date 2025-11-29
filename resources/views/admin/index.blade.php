@extends('layouts.app')

@section('title', 'Admin Panel - NexStack')
@section('page-title', 'ADMIN PANEL')

@section('content')

<div class="btn-group w-100 mb-3" role="group">
    <button type="button" class="btn btn-success active"  id="user-btn">Users Management</button>
    <button type="button" class="btn btn-success" id="pending-btn">Pending Messages</button>
</div>

<a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3" id="add-user-btn">
    <i class="bi bi-plus-circle"></i> Add User
</a>

<div class="card">
    <div class="card-header">
        @include('components._table_search', ['placeholder' => 'Search users...'])
    </div>
    <div class="card-body" id="user-body">
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
    <div class="card-body" id="pending-body">

    </div>
</div>

<script>
    const userBtn = document.getElementById('user-btn');
    const pendingBtn = document.getElementById('pending-btn');
    const userBody = document.getElementById('user-body');
    const pendingBody = document.getElementById('pending-body');
    const cardHeader = document.querySelector('.card-header');
    const addUserBtn = document.getElementById('add-user-btn');

    userBtn.addEventListener('click', () => {
        userBody.style.display = 'block';
        pendingBody.style.display = 'none';
        cardHeader.style.display = 'block';
        addUserBtn.style.display = 'inline-block';
        pendingBtn.classList.remove('active');
        userBtn.classList.add('active');
    });

    pendingBtn.addEventListener('click', () => {
        userBody.style.display = 'none';
        pendingBody.style.display = 'block';
        cardHeader.style.display = 'none';
        addUserBtn.style.display = 'none';
        userBtn.classList.remove('active');
        pendingBtn.classList.add('active');
    });
</script>
@endsection

