<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // لاستخدام دالة Str::slug
use App\Models\Setting; // Import the Setting model

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::all();
        // Get the daily free limit from the settings table
        $dailyFreeLimit = Setting::where('key', 'daily_free_limit')->first();
        return view('admin.subscriptions.index', compact('subscriptions', 'dailyFreeLimit'));
    }

    // Add a new method to save the settings
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
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscriptions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // app/Http/Controllers/SubscriptionController.php

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
        $validatedData['features_ar'] = json_encode(array_values(array_filter($request->features_ar ?? [])));
        $validatedData['features_en'] = json_encode(array_values(array_filter($request->features_en ?? [])));

        $validatedData['slug'] = Str::slug($validatedData['name_en']);

        Subscription::create($validatedData);

        return redirect()->route('subscriptions.index')
            ->with('success', 'تم إنشاء الباقة بنجاح!');
    }
    // في دالة update

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        return view('admin.subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        return view('admin.subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'price' => 'required|numeric',
            'daily_operations_limit' => 'nullable|integer',
            'duration_in_days' => 'required|integer',
            'features_ar' => 'nullable|string',
            'features_en' => 'nullable|string',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name_en']);

        $subscription->update($validatedData);

        return redirect()->route('subscriptions.index')
            ->with('success', 'تم تحديث الباقة بنجاح!');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()->route('subscriptions.index')
            ->with('success', 'تم حذف الباقة بنجاح!');
    }
}
