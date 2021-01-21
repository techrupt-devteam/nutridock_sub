<?php

namespace App\Http\Middleware;

use Closure;

class MangerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $data =\Sentinel::check('email');
        if(empty($data->email)) 
        {
            return redirect('login');
        }
        
        return $next($request);
    }
}
