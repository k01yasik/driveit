<?php

namespace App\Http\Controllers\Auth;

use App\Services\SeoService;
use App\User;
use App\Profile;
use App\Album;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $seoService;

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $profile = new Profile;
        $profile->avatar = config('app.url').'/storage/avatars/default-user.jpg';
        $profile->public = false;
        $profile->user()->associate($user);
        $profile->save();

        $album = new Album;
        $album->name = 'posts';
        $album->user()->associate($user);
        $album->save();


        return $user;
    }

    public function showRegistrationForm(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        return view('auth.register', compact('seo'));
    }
}
