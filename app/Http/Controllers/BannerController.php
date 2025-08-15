<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all banners or create default ones if they don't exist
        $banners = collect(['banner_1', 'banner_2', 'banner_3', 'banner_4', 'banner_5', 'banner_6', 'banner_7'])->map(function ($name, $index) {
            return Banner::firstOrCreate(
                ['name' => $name],
                ['order' => $index + 1, 'is_active' => true]
            );
        });

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Save banners data
     */
    public function save(Request $request)
    {
        $request->validate([
            'banner_1' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,avi,mov,webm|max:10240',
            'banner_2' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,avi,mov,webm|max:10240',
            'banner_3' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,avi,mov,webm|max:10240',
            'banner_4' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,avi,mov,webm|max:10240',
            'banner_5' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,avi,mov,webm|max:10240',
            'banner_6' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,avi,mov,webm|max:10240',
            'banner_7' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,avi,mov,webm|max:10240',
            'banner_1_url' => 'nullable|url',
            'banner_2_url' => 'nullable|url',
            'banner_3_url' => 'nullable|url',
            'banner_4_url' => 'nullable|url',
            'banner_5_url' => 'nullable|url',
            'banner_6_url' => 'nullable|url',
            'banner_7_url' => 'nullable|url',
        ]);

        for ($i = 1; $i <= 7; $i++) {
            $bannerName = "banner_{$i}";
            $banner = Banner::firstOrCreate(
                ['name' => $bannerName],
                ['order' => $i, 'is_active' => true]
            );

            // Handle file upload
            if ($request->hasFile($bannerName)) {
                // Delete old file if exists
                if ($banner->file_path && Storage::disk('public')->exists('banners/' . $banner->file_path)) {
                    Storage::disk('public')->delete('banners/' . $banner->file_path);
                }

                $file = $request->file($bannerName);
                $filename = time() . '_' . $i . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                // Store file
                $file->storeAs('banners', $filename, 'public');

                $banner->update([
                    'file_path' => $filename,
                    'file_type' => $file->getClientOriginalExtension(),
                ]);
            }

            // Handle URL
            $urlField = "{$bannerName}_url";
            if ($request->has($urlField)) {
                $banner->update(['url' => $request->input($urlField)]);
            }
        }

        return redirect()->route('banners.index')->with('success', 'تم حفظ البانرات بنجاح');
    }

    /**
     * Toggle banner status
     */
    public function toggleStatus($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update(['is_active' => !$banner->is_active]);

        $status = $banner->is_active ? 'مفعل' : 'معطل';
        return redirect()->back()->with('success', "تم تحديث حالة البانر إلى {$status}");
    }

    /**
     * Delete banner file
     */
    public function deleteFile($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->file_path && Storage::disk('public')->exists('banners/' . $banner->file_path)) {
            Storage::disk('public')->delete('banners/' . $banner->file_path);
        }

        $banner->update([
            'file_path' => null,
            'file_type' => null,
        ]);

        return redirect()->back()->with('success', 'تم حذف ملف البانر بنجاح');
    }

    /**
     * Get banners for API or frontend
     */
    public function getBanners()
    {
        $banners = Banner::active()->ordered()->get()->map(function ($banner) {
            return [
                'id' => $banner->id,
                'name' => $banner->name,
                'file_url' => $banner->file_url,
                'file_type' => $banner->file_type,
                'url' => $banner->url,
                'is_image' => $banner->isImage(),
                'is_video' => $banner->isVideo(),
                'is_animated' => $banner->isAnimated(),
            ];
        });

        return response()->json($banners);
    }
}
