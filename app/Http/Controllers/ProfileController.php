<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function userProfileUpdate(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'          => ['required', 'string', 'max:255'],
        'email'         => ['required', 'email', 'unique:users,email,' . $user->id],
        'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        'password'      => ['nullable', 'confirmed'],
    ]);

    // ✅ আগে $validated initialize করতে হবে
    $validated = [
        'name'  => $request->name,
        'email' => $request->email,
    ];

    if ($request->hasFile('profile_image')) {
        // ✅ পুরনো image delete করুন
        if ($user->profile_image) {
            $oldPath = public_path('uploads/profile/' . $user->profile_image);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $image     = $request->file('profile_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('uploads/profile'), $imageName);
        $validated['profile_image'] = $imageName;
    }

    if ($request->filled('password')) {
        $validated['password'] = Hash::make($request->password);
    }

    $user->update($validated);

    return redirect()->route('profile.edit')
        ->with('success', 'Profile updated successfully!');
}
    
}