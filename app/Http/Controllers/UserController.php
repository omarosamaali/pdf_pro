<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('subscription')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $subscriptions = Subscription::all();
        return view('admin.users.create', compact('subscriptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
            'subscription_id' => 'nullable|exists:subscriptions,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'subscription_id' => $request->subscription_id,
        ]);

        return redirect()->route('users.index')->with('success', 'تم إضافة المستخدم بنجاح.');
    }

    public function show(User $user)
    {
        $user->load('subscription');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $subscriptions = Subscription::all();
        return view('admin.users.edit', compact('user', 'subscriptions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'subscription_id' => 'nullable|exists:subscriptions,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'subscription_id' => $request->subscription_id,
        ]);

        return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
