<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Dashboard\CreateUserRequest;
use App\Http\Requests\Dashboard\UpdateUserRequest;
use App\Http\Requests\Dashboard\DeleteUserRequest;
use App\Http\Requests\UpdateOwnAccountSettingsRequest;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('id')->paginate(10);

        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $user = new User();

        return view('dashboard.users.editor', compact('user', 'roles', 'permissions'));
    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        if (isset($data['role'])) {
            $user->roles()->sync([$data['role']]);
        }
        $user->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('dashboard.users.edit', $user)->with(['success' => true, 'new-user' => true]);
    }

    public function edit(User $user)
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $user->load('roles.permissions', 'permissions');

        return view('dashboard.users.editor', compact('user', 'roles', 'permissions'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $user->update($data);
        if (isset($data['role'])) {
            $user->roles()->sync([$data['role']]);
        }
        $user->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('dashboard.users.edit', $user)->with('success', true);
    }

    public function destroy(DeleteUserRequest $request, User $user)
    {
        $user->delete();

        return redirect()->route('dashboard.users.index')->with([
            'message' => __('The :target is permanently deleted.', ['target' => 'user']),
        ]);
    }

    public function settings(User $user)
    {
        if ($user->id != auth()->user()->id) {
            return redirect()->route('dashboard.users.edit', $user);
        }

        return view('dashboard.users.settings', compact('user'));
    }

    public function updateSettings(UpdateOwnAccountSettingsRequest $request, User $user)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user->update($data);

        return redirect()->route('dashboard.users.settings', $user)->with('success', true);
    }

}
