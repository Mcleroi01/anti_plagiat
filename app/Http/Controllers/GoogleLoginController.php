<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Nette\Utils\Random;

class GoogleLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
{
    try {
        // Attempt to retrieve the authenticated user's information from Google
        $googleUser = Socialite::driver('google')->stateless()->user();
    } catch (Exception $e) {
        // Log the error for debugging
        Log::error('Google Auth Error: ' . $e->getMessage());

        // Redirect back with an error message
        return redirect()->route('login')->with('error', 'Failed to authenticate with Google. Please try again.');
    }

    // Find the user by email or create a new user if they don't exist
    $user = User::where('email', $googleUser->email)->first();
    if (!$user) {
        $user = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => Hash::make(rand(100000, 999999)), // Using a random password
        ]);
    }


    $user->assignRole('user');

    // Log the user in
    Auth::login($user);

    // Redirect the user to the intended route (e.g., dashboard)
    return redirect()->intended(route('dashboard'));
}
}
