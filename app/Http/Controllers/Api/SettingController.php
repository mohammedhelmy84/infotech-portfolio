<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json(Setting::all());
    }

    public function store(Request $request)
    {
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

        $setting->update($data);
        return response()->json($setting);
    }

  
    public function destroy(Setting $setting)
    {
        $setting->delete();
        return response()->json(null, 204);
    }
}
 