<?php

namespace Royalcms\Component\Foundation\Auth;

use Royalcms\Component\Http\Request;
use Royalcms\Component\Cache\RateLimiter;
use Royalcms\Component\Support\Facades\Lang;

trait ThrottlesLogins
{
    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return app(RateLimiter::class)->tooManyAttempts(
            $this->getThrottleKey($request),
            $this->maxLoginAttempts(), $this->lockoutTime() / 60
        );
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @return int
     */
    protected function incrementLoginAttempts(Request $request)
    {
        app(RateLimiter::class)->hit(
            $this->getThrottleKey($request)
        );
    }

    /**
     * Determine how many retries are left for the user.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @return int
     */
    protected function retriesLeft(Request $request)
    {
        $attempts = royalcms(RateLimiter::class)->attempts(
            $this->getThrottleKey($request)
        );

        return $this->maxLoginAttempts() - $attempts + 1;
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @return \Royalcms\Component\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = royalcms(RateLimiter::class)->availableIn(
            $this->getThrottleKey($request)
        );

        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getLockoutErrorMessage($seconds),
            ]);
    }

    /**
     * Get the login lockout error message.
     *
     * @param  int  $seconds
     * @return string
     */
    protected function getLockoutErrorMessage($seconds)
    {
        return Lang::has('auth.throttle')
            ? Lang::get('auth.throttle', ['seconds' => $seconds])
            : 'Too many login attempts. Please try again in '.$seconds.' seconds.';
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @return void
     */
    protected function clearLoginAttempts(Request $request)
    {
        app(RateLimiter::class)->clear(
            $this->getThrottleKey($request)
        );
    }

    /**
     * Get the throttle key for the given request.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @return string
     */
    protected function getThrottleKey(Request $request)
    {
        return mb_strtolower($request->input($this->loginUsername())).'|'.$request->ip();
    }

    /**
     * Get the maximum number of login attempts for delaying further attempts.
     *
     * @return int
     */
    protected function maxLoginAttempts()
    {
        return property_exists($this, 'maxLoginAttempts') ? $this->maxLoginAttempts : 5;
    }

    /**
     * The number of seconds to delay further login attempts.
     *
     * @return int
     */
    protected function lockoutTime()
    {
        return property_exists($this, 'lockoutTime') ? $this->lockoutTime : 60;
    }
}
