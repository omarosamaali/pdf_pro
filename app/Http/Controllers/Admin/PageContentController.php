<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

class PageContentController extends Controller
{

    public function showPrivacyPolicy()
    {
        $content = PageContent::first();

        $locale = app()->getLocale();
        $privacyPolicy = $content ? $content->{"privacy_policy_{$locale}"} : null;

        $content = PageContent::first();
        $terms = $content ? $content->{"terms_{$locale}"} : null;

        return view('privacy-policy', compact('privacyPolicy' , 'terms'));
    }

    public function index()
    {
        // ابحث عن سجل واحد فقط، أو أنشئ سجل جديد إذا لم يكن موجودًا
        $content = PageContent::firstOrNew([]);
        return view('admin.page_contents.index', compact('content'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'privacy_policy_ar' => 'nullable|string',
            'privacy_policy_en' => 'nullable|string',
            'terms_ar' => 'nullable|string',
            'terms_en' => 'nullable|string',
        ]);

        // ابحث عن السجل الأول أو أنشئ سجل جديد وقم بتحديثه
        $content = PageContent::firstOrNew([]);
        $content->fill($request->all());
        $content->save();

        return redirect()->route('admin.page_contents.index')->with('success', 'تم تحديث المحتوى بنجاح!');
    }
}
