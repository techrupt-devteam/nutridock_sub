<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        
        $data = \Session::get('user');
        if(empty($data)) 
        {
           return redirect('admin/login');
        } 

        return $next($request);
    }
}
