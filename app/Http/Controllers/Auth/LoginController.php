<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Socialite;
use App\Services\SeoService;
use Illuminate\Http\Request;
use App\User;
use App\Profile;

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

        $authUser = $this->findOrCreateUser($user, 'facebook');

        Auth::login($authUser, true);

        return redirect()->route('user.profile', ['username' => $authUser->username]);
    }

    public function handleProviderCallbackGoogle()
    {
        $user = Socialite::driver('google')->user();

        $authUser = $this->findOrCreateUser($user, 'google');

        Auth::login($authUser, true);

        return redirect()->route('user.profile', ['username' => $authUser->username]);
    }

    public function showLoginForm(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);
        return view('auth.login', compact('seo'));
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();

        if ($authUser) {
            return $authUser;
        }

        $userCreate = User::create([
           'username' => $user->id,
           'email' => $user->email,
           'provider' => $provider,
           'provider_id' => $user->id
        ]);

        $profile = new Profile;
        $profile->avatar = $user->avatar;
        $profile->public = false;
        $profile->user()->associate($userCreate);
        $profile->save();

        return $userCreate;
    }

    public function logout(Request $request)
    {
        $user_id = Auth::id();

        Cache::forget('user_with_profile_'.$user_id);

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
