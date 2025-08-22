<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Setting;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::all();
        $dailyFreeLimit = Setting::where('key', 'daily_free_limit')->first();
        return view('admin.subscriptions.index', compact('subscriptions', 'dailyFreeLimit'));
    }

    /**
     * Save the settings
     */
    public function saveSettings(Request $request)
    {
        $request->validate([
            'daily_free_limit' => 'required|integer|min:0',
        ]);

        Setting::updateOrCreate(
            ['key' => 'daily_free_limit'],
            ['value' => $request->daily_free_limit]
        );

        return back()->with('success', 'تم حفظ إعدادات المحاولات المجانية بنجاح!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subscriptions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'price' => 'required|numeric',
            'daily_operations_limit' => 'nullable|integer',
            'duration_in_days' => 'required|integer',
            'features_ar' => 'nullable|array',
            'features_en' => 'nullable|array',
            'features_ar.*' => 'nullable|string',
            'features_en.*' => 'nullable|string',
        ]);

        // تحويل المصفوفات إلى JSON قبل الحفظ
        $validatedData['features_ar'] = json_encode(array_values(array_filter($request->features_ar ?? [])), JSON_UNESCAPED_UNICODE);
        $validatedData['features_en'] = json_encode(array_values(array_filter($request->features_en ?? [])), JSON_UNESCAPED_UNICODE);

        $validatedData['slug'] = Str::slug($validatedData['name_en']);

        Subscription::create($validatedData);

        return redirect()->route('subscriptions.index')
            ->with('success', 'تم إنشاء الباقة بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        return view('admin.subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        return view('admin.subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'price' => 'required|numeric',
            'daily_operations_limit' => 'nullable|integer',
            'duration_in_days' => 'required|integer',
            'features_ar' => 'nullable|array', // تغيير من string إلى array
            'features_en' => 'nullable|array', // تغيير من string إلى array
            'features_ar.*' => 'nullable|string',
            'features_en.*' => 'nullable|string',
        ]);

        // تحويل المصفوفات إلى JSON قبل الحفظ (نفس طريقة store)
        $validatedData['features_ar'] = json_encode(array_values(array_filter($request->features_ar ?? [])), JSON_UNESCAPED_UNICODE);
        $validatedData['features_en'] = json_encode(array_values(array_filter($request->features_en ?? [])), JSON_UNESCAPED_UNICODE);

        $validatedData['slug'] = Str::slug($validatedData['name_en']);

        $subscription->update($validatedData);

        return redirect()->route('subscriptions.index')
            ->with('success', 'تم تحديث الباقة بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()->route('subscriptions.index')
            ->with('success', 'تم حذف الباقة بنجاح!');
    }

    /**
     * Display subscriptions for regular users
     */
    public function userIndex()
    {
        $subscriptions = Subscription::all();
        $userSubscription = auth()->user()->subscription;

        return view('subscriptions.user-index', compact('subscriptions', 'userSubscription'));
    }

    /**
     * Display user's subscription history
     */
    public function history()
    {
        $user = auth()->user()->load('subscription');

        // If you have a subscription history table, load it here
        // $subscriptionHistory = SubscriptionHistory::where('user_id', auth()->id())->get();

        return view('subscriptions.history', compact('user'));
    }

    /**
     * Subscribe user to a plan
     */
    public function subscribe(Request $request, Subscription $subscription)
    {
        $user = auth()->user();

        // Update user's subscription
        $user->update([
            'subscription_id' => $subscription->id,
            'subscription_start_date' => now(),
            'subscription_end_date' => now()->addDays($subscription->duration_in_days),
        ]);

        return redirect()->route('profile.edit')
            ->with('success', __('messages.subscription_activated_successfully'));
    }

    /**
     * Cancel user's subscription
     */
    public function cancel(Request $request)
    {
        $user = auth()->user();

        $user->update([
            'subscription_id' => null,
            'subscription_start_date' => null,
            'subscription_end_date' => null,
        ]);

        return redirect()->route('profile.edit')
            ->with('success', __('messages.subscription_cancelled_successfully'));
    }
}
