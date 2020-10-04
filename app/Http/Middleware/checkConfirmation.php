<?php

namespace App\Http\Middleware;

use Closure;
use App\Order;

class checkConfirmation
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
        if ($request->input('orders') != null) {
            $isConfirm = false;
            $orders = Order::find($request->input('orders'));
            foreach ($orders as $order) {
                if ($order->is_viewed == 1) {
                    $isConfirm = true;
                    break;
                }
            }
            if ($isConfirm === true) {
                return redirect('orders')->with('fail', 'بعضی از حواله ها توسط باربری تایید شده است و قابل ویرایش یا حذف نمی باشد.');
            }
        } elseif ($request->input('confirmed') === '1') {
            return redirect('orders')->with('fail', 'حواله توسط باربری تایید شده است و قابل ویرایش یا حذف نمی باشد.');
        }
        return $next($request);
    }
}
