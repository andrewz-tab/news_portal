<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\User\Service;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\Permission\StoreForUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function add_permission(User $user)
    {
        return view('admin_panel.user.permission', compact('user'));
    }
    public function ban(User $user)
    {
        $user->is_banned = true;
        $user->save();
        return redirect()->back()->with('success', 'Пользователь ' . $user->name . ' заблокирован');
    }
    public function create()
    {
        return view('admin_panel.user.create');
    }
    public function destroy()
    {
        $users = User::withTrashed()->orderByDesc('created_at')->paginate(10);
        return view('admin_panel.user.index', compact('users'));
    }
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin_panel.user.edit', compact('user', 'roles'));
    }
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(10);
        return view('admin_panel.user.index', compact('users'));
    }
    public function restore()
    {
        return view('admin_panel.user.index', compact('users'));
    }
    public function show(User $user)
    {
        return view('admin_panel.user.show', compact('user'));
    }
    public function store(StoreRequest $request)
    {
        //////////////////////////////////////////////////
        $data = $request->validated();
        $user = User::create(
            [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            ]
        );
        $user->assignRole(Role::findOrCreate('user'));
        return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно создан');
    }
    public function store_permission(StoreForUserRequest $request, User $user)
    {
        $data = $request->validated();
        $message = $this->service->storePermission($user, $data);
        return redirect()->route('admin.users.edit', $user->id)->with('success', $message);
    }
    public function unban(User $user)
    {
        $user->is_banned = false;
        $user->save();
        return redirect()->back()->with('success', 'Пользователь ' . $user->name . ' разблокирован');
    }
    public function update(Request $request, User $user)
    {
        dd($request->input('roles_id'));
        return redirect()->route('admin.users.show', 3);
    }
}
