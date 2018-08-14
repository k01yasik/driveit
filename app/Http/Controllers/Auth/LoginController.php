<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Services\SeoService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $seoService;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SeoService $seoService)
    {
        $this->middleware('guest')->except('logout');
        $this->seoService = $seoService;
    }

    public function username()
    {
        return 'username';
    }

    public function redirectToProviderFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallbackFacebook()
    {
        $user = Socialite::driver('facebook')->user();

        return $user;
    }

    public function handleProviderCallbackGoogle()
    {
        $user = Socialite::driver('google')->user();

        return $user;
    }

    public function showLoginForm(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);
        return view('auth.login', compact('seo'));
    }
}
