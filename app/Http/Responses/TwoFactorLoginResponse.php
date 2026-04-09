<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;
use Illuminate\Support\Facades\Auth;

class TwoFactorLoginResponse implements TwoFactorLoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = Auth::user();

        // If the user is an Admin, send them to the Admin Dashboard
        // Adjust 'is_admin' to match your actual database column or logic
        if ($user && $user->is_admin) {
            return redirect()->route('admin.home');
        }

        // Otherwise, send them to the standard home/dashboard
        return redirect()->intended(config('fortify.home'));
    }
}