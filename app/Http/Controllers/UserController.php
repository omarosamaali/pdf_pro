<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // تأكد من استيراد الموديل
use Illuminate\Support\Facades\Hash; // لاستخدام تجزئة كلمة المرور

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // جلب جميع المستخدمين مع معلومات الاشتراك
        $users = User::all();

        // إرسال البيانات إلى الواجهة
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
            // 'daily_operations' => 'nullable|integer',
            // 'subscription_id' => 'nullable|exists:subscriptions,id',
        ]);

        // إنشاء مستخدم جديد
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // تجزئة كلمة المرور
            'role' => $request->role,
            // 'daily_operations' => $request->daily_operations ?? 0,
            // 'subscription_id' => $request->subscription_id,
        ]);

        return redirect()->route('users.index')->with('success', 'تم إضافة المستخدم بنجاح.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // عرض نموذج تعديل المستخدم
        return view('admin.users.edit', compact('user'));
    }
    public function create()
    {
        // يمكنك إرسال بيانات الاشتراكات هنا إذا كانت موجودة
        // $subscriptions = Subscription::all();
        // return view('admin.users.create', compact('subscriptions'));

        return view('admin.users.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // عرض تفاصيل المستخدم
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string',
            // 'daily_operations' => 'nullable|integer',
            // 'subscription_id' => 'nullable|exists:subscriptions,id',
        ]);

        // تحديث بيانات المستخدم
        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // حذف المستخدم
        $user->delete();

        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
