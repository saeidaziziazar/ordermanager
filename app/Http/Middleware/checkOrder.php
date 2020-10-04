<?php

namespace App\Http\Middleware;

use Closure;
use App\Order;

class checkOrder
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
            return redirect('orders')->with('fail', 'حداقل یک حواله و حداکثر سه حواله باید انتخاب شوند');
        }

        $base_transportation = Order::find($request->input('orders')[0])->transportation_id;
        $base_owner = Order::find($request->input('orders')[0])->owner_id;

        foreach($request->input('orders') as $order) {
            $tarnsportation_id = Order::find($order)->transportation_id;
            
            if ($base_transportation != $tarnsportation_id) {
                return redirect('orders')->with('fail', 'حواله های انتخاب شده باید به یک باربری متعلق  باشند');
            }
        }

        foreach($request->input('orders') as $order) {
            $owner_id = Order::find($order)->owner_id;
            
            if ($base_owner != $owner_id) {
                return redirect('orders')->with('fail', 'حواله های انتخاب شده باید به یک مالک متعلق  باشند');
            }
        }

        return $next($request);
    }
}
