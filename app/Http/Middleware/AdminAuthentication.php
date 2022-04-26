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
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (empty($guards)) {
            $guards = [null];
            // $this->unauthenticated($request, $guards);
        }
        $isAuthenticated = null;
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                if($this->auth->user()->type != config('user.admin'))
                {
                    $this->auth->guard($guard)->logout();
                    return redirect()->to(route('admin.login'))->with('failure','User does not have authorization');
                }
                $this->auth->shouldUse($guard);
                $isAuthenticated = 1;
                break;
            }
            else {
            }
        }
        if (!$isAuthenticated)
            $this->unauthenticated($request, $guards);


        return $next($request);
    }

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
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                if($this->auth->user()->type !=config('user.admin'))
                {
                    $this->auth->guard($guard)->logout();
                    // return redirect()->to(route('admin.login'))->with('failure','User does not have authorization');
                }
                return $this->auth->shouldUse($guard);
            }
        }
        // foreach ($guards as $guard) {
        //     if ($this->auth->guard($guard)->check()) {
        //         return $this->auth->shouldUse($guard);
        //     }
        // }

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
        return route('admin.login');
    }
}
