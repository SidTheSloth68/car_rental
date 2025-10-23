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
                                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
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
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>License</th>
                            <th>Role</th>
                            <th>Bookings</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    @if($user->profile_photo)
                                        <img src="{{ asset($user->profile_photo) }}" alt="{{ $user->name }}" 
                                             class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px; color: white; font-weight: bold;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $user->name }}</div>
                                    @if($user->address)
                                        <small class="text-muted">{{ Str::limit($user->address, 30) }}</small>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? 'N/A' }}</td>
                                <td>
                                    @if($user->license_number)
                                        <span class="badge badge-info">{{ $user->license_number }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
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
                                <td colspan="10" class="text-center text-muted py-4">
                                    No users found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                    </div>
                    <nav>
                        <ul class="pagination mb-0">
                            {{-- Previous Page Link --}}
                            @if ($users->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">Previous</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($users->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
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
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="+1-555-0123">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="role">Role *</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="license_number">License Number</label>
                                <input type="text" class="form-control" id="license_number" name="license_number" placeholder="DL12345678">
                                <small class="form-text text-muted">Driver's license number (optional)</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="profile_photo">Profile Photo</label>
                                <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*">
                                <small class="form-text text-muted">Upload profile picture (JPG, PNG - max 2MB)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="2" placeholder="Full address (optional)"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password">Password *</label>
                                <input type="password" class="form-control" id="password" name="password" required minlength="8">
                                <small class="form-text text-muted">Minimum 8 characters</small>
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
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="editUserForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_user_id" name="user_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="edit_name">Full Name *</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="edit_email">Email Address *</label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="edit_phone">Phone Number</label>
                                <input type="text" class="form-control" id="edit_phone" name="phone" placeholder="+1 234 567 8900">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="edit_role">Role *</label>
                                <select class="form-control" id="edit_role" name="role" required>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_address">Address</label>
                        <textarea class="form-control" id="edit_address" name="address" rows="2" placeholder="Full address"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="edit_license_number">Driver's License Number</label>
                                <input type="text" class="form-control" id="edit_license_number" name="license_number" placeholder="DL12345678">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="edit_profile_photo">Profile Photo</label>
                                <input type="file" class="form-control" id="edit_profile_photo" name="profile_photo" accept="image/*">
                                <small class="form-text text-muted">Max 2MB (JPG, PNG, GIF)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div id="edit_current_photo" class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit form submission
    const editForm = document.getElementById('editUserForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const userId = document.getElementById('edit_user_id').value;
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
            
            fetch(`/admin/users/${userId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.message || 'User updated successfully!');
                    location.reload();
                } else {
                    alert(data.message || 'Error updating user.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating user. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }

    // Auto-submit form on role change
    const roleSelect = document.getElementById('role');
    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
});

function viewUser(userId) {
    const modal = new bootstrap.Modal(document.getElementById('viewUserModal'));
    const contentDiv = document.getElementById('userDetailsContent');
    
    // Show loading spinner
    contentDiv.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    
    modal.show();
    
    // Fetch user details
    fetch(`/admin/users/${userId}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const user = data.user;
            let photoHtml = '';
            
            if (user.profile_photo) {
                photoHtml = `<img src="/${user.profile_photo}" alt="${user.name}" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">`;
            } else {
                photoHtml = `<div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px; color: white; font-weight: bold; font-size: 32px;">${user.name.charAt(0).toUpperCase()}</div>`;
            }
            
            contentDiv.innerHTML = `
                <div class="text-center">
                    ${photoHtml}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> ${user.name}</p>
                        <p><strong>Email:</strong> ${user.email}</p>
                        <p><strong>Phone:</strong> ${user.phone || 'N/A'}</p>
                        <p><strong>Role:</strong> <span class="badge badge-${user.role === 'admin' ? 'success' : 'primary'}">${user.role.toUpperCase()}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>License Number:</strong> ${user.license_number || 'N/A'}</p>
                        <p><strong>Address:</strong> ${user.address || 'N/A'}</p>
                        <p><strong>Joined:</strong> ${new Date(user.created_at).toLocaleDateString()}</p>
                        <p><strong>Total Bookings:</strong> ${user.bookings ? user.bookings.length : 0}</p>
                    </div>
                </div>
            `;
        } else {
            throw new Error('Failed to load user data');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        contentDiv.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> Error loading user details.
            </div>
        `;
    });
}

function editUser(userId) {
    const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
    
    // Fetch user details
    fetch(`/admin/users/${userId}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const user = data.user;
            
            // Populate form
            document.getElementById('edit_user_id').value = user.id;
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_phone').value = user.phone || '';
            document.getElementById('edit_role').value = user.role;
            document.getElementById('edit_address').value = user.address || '';
            document.getElementById('edit_license_number').value = user.license_number || '';
            
            // Show current photo
            const photoDiv = document.getElementById('edit_current_photo');
            if (user.profile_photo) {
                photoDiv.innerHTML = `
                    <div class="alert alert-info">
                        <strong>Current Photo:</strong><br>
                        <img src="/${user.profile_photo}" alt="${user.name}" class="rounded mt-2" style="max-width: 100px;">
                    </div>
                `;
            } else {
                photoDiv.innerHTML = '';
            }
            
            // Set form action
            document.getElementById('editUserForm').action = `/admin/users/${user.id}`;
            
            modal.show();
        } else {
            throw new Error('Failed to load user data');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading user details for editing.');
    });
}

function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?\n\nThis action cannot be undone and will also remove all associated bookings and data.')) {
        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message || 'Error deleting user.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting user.');
        });
    }
}
</script>
@endsection