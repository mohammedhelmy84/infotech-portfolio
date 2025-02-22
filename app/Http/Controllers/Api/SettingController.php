<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json(Setting::first());
    }

    public function store(Request $request)
    {
        $mainSetting = Setting::first();
        if ($mainSetting) {
            return response()->json(['error' => 'لا تستطيع عمل اكتر من اعدادات'], 400);
        } 

        $data = $request->validate([
            'name'        => 'nullable|string',
            'description' => 'nullable|string',
           'logo'        => 'nullable|string',
           'favicon'     => 'nullable|string',
            'email'       => 'nullable|email',
            'phone'       => 'nullable|string',
            'address'     => 'nullable|string',
            'facebook'    => 'nullable|url',
            'twitter'     => 'nullable|url',
            'instagram'   => 'nullable|url',
            'youtube'     => 'nullable|url',
            'tiktok'      => 'nullable|url',
        ]);

        $setting = Setting::create($data);
        return response()->json($setting, 201);
    }

 
    public function show(Setting $setting)
    {
        return response()->json($setting);
    }


    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'name'        => 'nullable|string',
            'description' => 'nullable|string',
            'logo'        => 'nullable|string',
            'favicon'     => 'nullable|string',
            'email'       => 'nullable|email',
            'phone'       => 'nullable|string',
            'address'     => 'nullable|string',
            'facebook'    => 'nullable|url',
            'twitter'     => 'nullable|url',
            'instagram'   => 'nullable|url',
            'youtube'     => 'nullable|url',
            'tiktok'      => 'nullable|url',
        ]);

        $data = $request->all();
        $setting->update($data);
        return response()->json($setting);
    }

  
    public function destroy(Setting $setting)
    {
        $setting->delete();
        return response()->json('تم حذف الرساله', 200);

    }
}
 
