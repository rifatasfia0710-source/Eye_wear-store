<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        $user     = Auth::user();
    $settings = \App\Models\Setting::pluck('value', 'key'); // key=>value collection
    return view('admin.settings.index', compact('user', 'settings'));
    }

    // ── General Settings ──
    public function updateGeneral(Request $request)
{
    $formType = $request->input('form_type', 'website');

    if ($formType === 'shipping') {

        $request->validate([
            'shipping_cost' => 'nullable|numeric|min:0',
            'free_shipping' => 'nullable|numeric|min:0',
            'cod_enabled'   => 'nullable|string',
        ]);

        $settings = array_filter([
            'shipping_cost' => $request->shipping_cost,
            'free_shipping' => $request->free_shipping,
            'cod_enabled'   => $request->cod_enabled,
        ], fn($v) => $v !== null && $v !== '');

    } else {

        $request->validate([
            'site_name'   => 'nullable|string|max:255',
            'admin_email' => 'nullable|email',
            'currency'    => 'nullable|string',
            'timezone'    => 'nullable|string',
        ]);

        $settings = array_filter([
            'site_name'   => $request->site_name,
            'admin_email' => $request->admin_email,
            'currency'    => $request->currency,
            'timezone'    => $request->timezone,
        ], fn($v) => $v !== null && $v !== '');
    }

    // শুধু যেগুলো পাঠানো হয়েছে সেগুলোই save হবে
    foreach ($settings as $key => $value) {
        \App\Models\Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    return redirect()->route('admin.settings.index')
        ->with('success', 'Settings updated successfully!')
        ->with('active_tab', 'general');
}

public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'          => 'nullable|string|max:255',
        'email'         => 'nullable|email|unique:users,email,' . $user->id,
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = array_filter([
        'name'  => $request->name,
        'email' => $request->email,
    ], fn($v) => $v !== null && $v !== '');

    if ($request->hasFile('profile_image')) {
        if ($user->profile_image) {
            $old = public_path('uploads/profile/' . $user->profile_image);
            if (file_exists($old)) unlink($old);
        }
        $image = $request->file('profile_image');
        $name  = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/profile'), $name);
        $data['profile_image'] = $name;
    }

    if (!empty($data)) {
        $user->update($data);
    }

    return redirect()->route('admin.settings.index')
        ->with('success', 'Profile updated successfully!')
        ->with('active_tab', 'profile');
}

public function updateSecurity(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'password'         => ['required', 'confirmed', Password::min(8)],
    ]);

    if (!Hash::check($request->current_password, Auth::user()->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect.']);
    }

    Auth::user()->update([
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('admin.settings.index')
        ->with('success', 'Password changed successfully!')
        ->with('active_tab', 'security');
}

public function updateNotifications(Request $request)
{
    $settings = [
        'notify_email'    => $request->has('notify_email')    ? '1' : '0',
        'notify_order'    => $request->has('notify_order')    ? '1' : '0',
        'notify_stock'    => $request->has('notify_stock')    ? '1' : '0',
        'notify_customer' => $request->has('notify_customer') ? '1' : '0',
    ];

    foreach ($settings as $key => $value) {
        \App\Models\Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    return redirect()->route('admin.settings.index')
        ->with('success', 'Notification preferences saved!')
        ->with('active_tab', 'notifications');
}
}