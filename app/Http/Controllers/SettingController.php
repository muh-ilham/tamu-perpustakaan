<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => Setting::get('app_name', 'Buku Tamu Perpustakaan'),
            'app_subtitle' => Setting::get('app_subtitle', 'BUKU TAMU DIGITAL PERPUSTAKAAN'),
            'app_logo' => Setting::get('app_logo'),
        ];
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_subtitle' => 'nullable|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        Setting::set('app_name', $request->app_name);
        Setting::set('app_subtitle', $request->app_subtitle);

        if ($request->hasFile('app_logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('app_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('app_logo')->store('settings', 'public');
            Setting::set('app_logo', $path);
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
