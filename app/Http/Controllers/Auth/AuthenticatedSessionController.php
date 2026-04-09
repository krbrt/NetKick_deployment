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
        // I-save muna ang cart session bago mag-regenerate para hindi ito mawala
        $cart = session('cart');

        $request->authenticate();

        $request->session()->regenerate();

        // I-restore ang cart items sa bagong session
        if ($cart) {
            session(['cart' => $cart]);
        }

        /**
         * REDIRECT PROTOCOL:
         * Pinapadala natin ito sa 'home' route. 
         * Ang HomeController@index ang magdedesisyon kung Admin dashboard 
         * o User dashboard ang dapat ipakita base sa usertype.
         */
        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect sa welcome page pagkatapos mag-logout
        return redirect('/');
    }
}