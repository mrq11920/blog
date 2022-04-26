<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Error;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests;
use Illuminate\Support\Facades\Log;

// use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     if (!auth()->user()) {
    //         return redirect()->to(route('admin.login'));
    //     }
    //     if (auth()->user()->type != config('user.admin')) {
    //         return redirect()->to(route('admin.login'))->with('failure', 'user does not have authorization');
    //     }

    //     // $guards = empty($guards) ? [null] : $guards;

    //     // foreach ($guards as $guard) {
    //     //     if (Auth::guard($guard)->check()) {
    //     //         return redirect(RouteServiceProvider::DASHBOARD);
    //     //     }
    //     // }
    //     return $next($request);
    // }
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {
    //     return route('admin.login');
    //     if (! $request->expectsJson()) {
    //         dd(route('admin.login'));
    //     }
    // }

       /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        error_log('construct adminmiddleware');
        $this->auth = $auth;
    }

   

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        error_log('authenticate adminmiddleware');

        if (empty($guards)) {
            $guards = [null];
            error_log('authenticate adminmiddleware| empty guards');
        }

        foreach ($guards as $guard) {
            error_log('guard --> '.$guard);
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        $this->unauthenticated($request, $guards);
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        error_log('unauthenticated adminmiddleware');

        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectTo($request)
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // error_log('redirectTo adminmiddleware');
        // error_log(route('admin.login'));
        return route('admin.login');
    }
}
