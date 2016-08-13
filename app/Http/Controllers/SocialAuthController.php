<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SocialAccountService;
use Socialite;

class SocialAuthController extends Controller
{
    /*
     * Social Authentication redirect handler
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /*
     * Social Authentication Callback handler
     */
    public function callback($provider, SocialAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver($provider)->user(), $provider);

        auth()->login($user);

        return redirect()->to('/home');
    }
}
