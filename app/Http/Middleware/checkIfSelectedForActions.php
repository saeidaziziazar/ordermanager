<?php

namespace App\Http\Middleware;

use Closure;

class checkIfSelectedForActions
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
        if(is_null($request->input('orders'))) {
            return redirect('orders')->with('fail', 'حداقل یک حواله باید انتخاب شود');
        }

        return $next($request);
    }
}
