<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class ProfileController extends Controller 
{
    public function edit() 
    {
        // Sirf ek baar edit function rakhein
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request) 
    {
        $user = Auth::user(); 
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);
        return back()->with('status', 'Profile updated successfully!');
    }

public function updatePassword(Request $request)
{
    // 1. Validation karo
    $request->validate([
        'current_password' => ['required', 'current_password'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    // 2. Agar validation pass ho gayi, toh password update karo
    $request->user()->update([
        'password' => Hash::make($request->password),
    ]);

    // 3. Success message bhejo
    return back()->with('status', 'Password updated successfully!');
}
// Ye method user ki details fetch karega
 public function show($id)
{

    // Database se user aur uski real activities fetch karein
    $user = User::with('activities')->findOrFail($id);

    return view('admin.user-profile', compact('user'));
}
}