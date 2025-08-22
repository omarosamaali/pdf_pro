<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $siteSetting = SiteSetting::first();
        return view('admin.site_settings.index', compact('siteSetting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'dashboard_name' => 'required|string|max:255',
        ]);

        $siteSetting = SiteSetting::firstOrNew();
        $siteSetting->site_name = $request->input('site_name');
        $siteSetting->dashboard_name = $request->input('dashboard_name');
        $siteSetting->save();

        return redirect()->back()->with('success', 'تم حفظ إعدادات الموقع بنجاح!');
    }
}
