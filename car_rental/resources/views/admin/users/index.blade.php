@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users Management</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="fas fa-plus fa-sm"></i> Add New User
        </button>
    </div>

    <!-- Filters and Search -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Search & Filter</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">Search Users</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Name, email, phone...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role">
                                <option value="">All Roles</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sort">Sort By</label>
                            <select class="form-control" id="sort" name="sort">
                                <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Latest</option>
                                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                                <option value="email" {{ request('sort') === 'email' ? 'selected' : '' }}>Email</option>
                                <option value="total_bookings" {{ request('sort') === 'total_bookings' ? 'selected' : '' }}>Total Bookings</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Users List ({{ $users->total() }} total)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Bookings</th>
                            <th>Loyalty Points</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $user->name }}</div>
                                    @if($user->address)
                                        <small class="text-muted">{{ Str::limit($user->address, 30) }}</small>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{ $user->role === 'admin' ? 'success' : 'primary' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="font-weight-bold">{{ $user->total_bookings ?? 0 }}</span>
                                    <small class="text-muted">bookings</small>
                                </td>
                                <td>
                                    <span class="font-weight-bold text-warning">{{ $user->loyalty_points ?? 0 }}</span>
                                    <small class="text-muted">pts</small>
                                </td>
                                <td>
                                    <div>{{ $user->created_at->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-info" 
                                                onclick="viewUser({{ $user->id }})" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" 
                                                onclick="editUser({{ $user->id }})" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($user->id !== auth()->id())
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="deleteUser({{ $user->id }})" title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    No users found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="email">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="role">Role *</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="customer">Customer</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password">Password *</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password_confirmation">Confirm Password *</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userDetailsContent">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewUser(userId) {
    // For now, show a simple alert. In a real application, you would load user details via AJAX
    alert('View user details for user ID: ' + userId + '\n\nThis feature will show detailed user information including booking history, loyalty points, and activity logs.');
}

function editUser(userId) {
    // For now, show a simple alert. In a real application, you would load edit form via AJAX
    alert('Edit user for user ID: ' + userId + '\n\nThis feature will allow you to modify user information, role, and account settings.');
}

function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?\n\nThis action cannot be undone and will also remove all associated bookings and data.')) {
        // For now, show a simple alert. In a real application, you would submit a delete request
        alert('Delete user ID: ' + userId + '\n\nUser deletion functionality would be implemented here with proper confirmation and data cleanup.');
    }
}

// Auto-submit form on role or sort change
document.getElementById('role').addEventListener('change', function() {
    this.form.submit();
});

document.getElementById('sort').addEventListener('change', function() {
    this.form.submit();
});
</script>
@endsection