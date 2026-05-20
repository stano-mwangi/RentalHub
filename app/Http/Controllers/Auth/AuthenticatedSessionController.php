<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

         $user = Auth::user();

 // ✅ Check for Super Admin flag directly
 if ($user->is_superadmin) {
    return redirect('/homeSuperAdmin');
}

$user->load('role');

// 🔥 Redirect based on role
if ($user->role?->name === 'admin') {
} elseif ($user->role?->name === 'user') {
    return redirect('properties');
} else {
            Auth::logout();
            return redirect('/login')->withErrors([
                'email' => 'Unauthorized role access.',
            ]);
        }
    }
 
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
