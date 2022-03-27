<?php

namespace App\Http\Middleware;

use Closure;

use Sentinel;

class AppCmsAuthorization
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
        if($user && $user->inRole('administrator')){
            $route = $request->route()->getAction();            
            if ( (isset($route['as'])) )
            {
                $as = $route['as'];
                if(!$user->hasAccess([$as])){
                    // akalin hehe
                    $asStoreAr = explode('.', $as);                    
                    if($asStoreAr[count($asStoreAr)-1] == 'store'){
                        return $next($request);
                    }
                    
                    abort(403, 'Forbidden');
                }                    
            }

        }else{
            return redirect()->route('cms.login');
        }

        return $next($request);
    }

}
