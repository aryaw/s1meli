<?php

namespace App\Http\Middleware;

use Closure;

use Sentinel;

class AppUserAuthorization
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        
    ];

    public function handle($request, Closure $next)
    {
        $user = Sentinel::check();
        if($user && $user->inRole('user')){
            return $next($request);
        }else{
            $request->session()->flash('login_message', 'silahkan login terlebih dahulu');
            return redirect()->route('site.register');
        }
        
    }

}
