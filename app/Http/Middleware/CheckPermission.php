<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $module
     * @param string $action
     * @return mixed
     */
    public function handle($request, Closure $next, $module, $action)
    {
        if($request->user() === null){
            return redirect('errors/404');
        }

        if($request->user()->group->hasPermission($module, $action)){
            return $next($request);
        }

        return redirect('errors/404');

    }
}
