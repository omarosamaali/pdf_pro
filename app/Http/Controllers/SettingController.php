<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $dailyFreeLimit = Setting::where('key', 'daily_free_limit')->first();
        return view('admin.settings.index', compact('dailyFreeLimit'));
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'daily_free_limit' => 'required|integer|min:0',
        ]);

        Setting::updateOrCreate(
            ['key' => 'daily_free_limit'],
            ['value' => $request->daily_free_limit]
        );

        return back()->with('success', 'تم حفظ الإعدادات بنجاح!');
    }
}
