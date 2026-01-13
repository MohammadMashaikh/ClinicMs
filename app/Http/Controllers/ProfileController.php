<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        $data = $request->validated();
        unset($data['profile_image']);
        
        // Remove empty password to avoid null overwrite
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->fill($data);
        $user->full_name = trim($user->first_name . ' ' . $user->last_name);

        // Reset email verification if changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        // Manually hash and assign password if filled
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile image
       if ($request->hasFile('profile_image')) {

        if ($user->hasRole('instructor')) {
            $user->clearMediaCollection('instructor-image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('instructor-image');
        } elseif ($user->hasRole('student')) {
            $user->clearMediaCollection('student-image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('student-image');
        }
    }


        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
