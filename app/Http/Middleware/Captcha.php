<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \ReCaptcha\ReCaptcha;

class Captcha
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $recaptcha = new ReCaptcha(config('recaptcha.private_key'));

        $response = $recaptcha->setExpectedHostname($request->server('SERVER_NAME'))
            ->setScoreThreshold(0.7)
            ->verify($request->recaptcha_token, $request->server('REMOTE_ADDR'));

        if (!$response->isSuccess()) {
            redirect()->back()->withErrors(['recaptcha' => 'ReCaptcha field is required.']);
        }

        if ($response->getScore() < 0.7) {
            redirect()->back()->withErrors(['recaptcha' => 'Failed to validate captcha']);
        }

        return $next($request);
    }
}
