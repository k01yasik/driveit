<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Services\SeoService;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $seoService;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
        $this->seoService = $seoService;
    }

    public function showResetForm(Request $request, $token = null)
    {
        $seo = $this->seoService->getSeoData($request);

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        )->with('seo', $seo);
    }
}
