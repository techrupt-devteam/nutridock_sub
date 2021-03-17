<?php

namespace App\Http\Middleware;

use Closure;

class SubscriberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        
        $data = \Session::get('subscriber_id');
        if(empty($data)) 
        {
           return redirect('subscribe-info');
        } 

        return $next($request);
    }
}
