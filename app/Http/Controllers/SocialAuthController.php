<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

use App\SocialAccountService;
use Socialite;

class SocialAuthController extends Controller
{
    public function redirect(Request $request)
    {
        $url = Input::get('url');
        session(['facebookRedirect' => $url]);
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(SocialAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());

        auth()->login($user);

        $url = session('facebookRedirect');
        $url = ( !is_null($url) ? $url : '/' );
        return redirect()->to($url);
    }
}
