<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = User::query();

    
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('bookings');
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }
        
        return view('admin.users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'license_number' => 'nullable|string|max:50',
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $userData = $request->only(['name', 'email', 'role', 'phone', 'address', 'license_number']);
        $userData['password'] = bcrypt($request->password);
        $userData['email_verified_at'] = now(); 
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/users'), $filename);
            $userData['profile_photo'] = 'images/users/' . $filename;
        }
        
        $user = User::create($userData);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User created successfully!',
                'user' => $user
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'license_number' => 'nullable|string|max:50',
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $userData = $request->only(['name', 'email', 'role', 'phone', 'address', 'license_number']);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                unlink(public_path($user->profile_photo));
            }
            
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/users'), $filename);
            $userData['profile_photo'] = 'images/users/' . $filename;
        }

        $user->update($userData);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully!',
                'user' => $user->fresh()
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        // Don't allow deleting the current admin
        if ($user->id === auth()->id()) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account'
                ], 403);
            }
            
            return redirect()->back()
                ->with('error', 'You cannot delete your own account');
        }

        $user->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully!'
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}