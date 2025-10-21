<?php
// app/Http/Controllers/Admin/UserController.php - ✅ FIXED VALIDATION
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends AdminController
{
    public function index(Request $request)
    {
        $query = User::with('profile');

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhereHas('profile', function($p) use ($request) {
                      $p->where('nim_nidn', 'like', "%{$request->search}%");
                  });
            });
        }

        // Filters
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // ✅ MANUAL VALIDATION
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,dosen,mahasiswa',
            'phone' => 'nullable|string|max:20',
            'nim_nidn' => [
                'nullable',
                'string',
                'max:20',
                'unique:user_profiles,nim_nidn'
            ],
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Assign role
        $user->assignRole($request->role);

        // Create profile
        if ($request->filled('nim_nidn')) {
            UserProfile::create([
                'user_id' => $user->id,
                'nim_nidn' => $request->nim_nidn,
            ]);
        }

        return redirect()->route('admin.users.index')
                       ->with('success', '✅ User "' . $request->name . '" berhasil dibuat!');
    }

    public function show(User $user)
    {
        $user->load(['profile', 'roles']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,dosen,mahasiswa',
            'phone' => 'nullable|string|max:20',
            'nim_nidn' => [
                'nullable',
                'string',
                'max:20',
                'unique:user_profiles,nim_nidn,' . ($user->profile?->id ?? 'NULL')
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->only(['name', 'email', 'phone', 'role', 'is_active']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles([$request->role]);

        // Update profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            ['nim_nidn' => $request->nim_nidn]
        );

        return redirect()->route('admin.users.index')
                       ->with('success', '✅ User "' . $user->name . '" berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if ($user->id === 1) {
            return back()->with('error', '❌ Super admin tidak bisa dihapus!');
        }

        $oldName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
                       ->with('success', '✅ User "' . $oldName . '" berhasil dihapus!');
    }

    public function toggleStatus(Request $request, User $user)
{
    if ($user->id === 1) {
        return response()->json(['success' => false, 'message' => 'Super admin tidak bisa diubah statusnya!']);
    }

    $user->update(['is_active' => !$user->is_active]);
    
    return response()->json([
        'success' => true,
        'is_active' => $user->is_active,
        'message' => $user->is_active ? 'User diaktifkan!' : 'User dinonaktifkan!'
    ]);
}
}