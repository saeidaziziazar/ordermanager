<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Costumer;
use App\Transportation;
use App\Order;
use App\Owner;
use App\User;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;
use DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
        $this->middleware('confirmed', ['only' => [
                'update',
                'destroy'
            ]
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Order::class);

        $formatted_tran = [
            '' => ''
        ];
        $formatted_owners = [
            '' => ''
        ];

        $trans = Transportation::all();
        $owners = Owner::all();

        foreach($trans as $tran) {
            $formatted_tran[$tran->id] = $tran->name;
        }

        foreach ($owners as $owner) {
            $formatted_owners[$owner->id] = $owner->name;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if(Auth::user()->transportation) {
                $orders = Auth::user()->transportation->orders->where('is_certain', '=', '1');
            } else {
                $orders = $this->getOrders($request);
            }
        } else {
            // dd($request->all());
            $orders = $this->getOrders($request);
        }        

        foreach ($orders as $order) {
            $order->date = Jalalian::forge($order->date)->format('%Y/%m/%d');
        }

        return view('order.index')->with(['orders' => $orders, 'trans' => $trans, 'owners' => $formatted_owners]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);

        $this->authorize('view', Order::class);

        return view('order.view')->with('order', $order);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($costumer_id = null)
    {
        $this->authorize('create', Order::class);

        $formatted_cos = [];
        $formatted_tran = [];
        $formatted_owners = [];

        $costumers = Costumer::all();
        $trans = Transportation::all();
        $owners = Owner::all();

        if (is_null($costumer_id)) $costumer_id = $costumers[0]->id;

        foreach($trans as $tran) {
            $formatted_tran[$tran->id] = $tran->name;
        }

        foreach ($costumers as $costumer) {
            $formatted_cos[$costumer->id] = $costumer->first_name . ' ' . $costumer->last_name . ' | ' . $costumer->national_code;
        }

        foreach ($owners as $owner) {
            $formatted_owners[$owner->id] = $owner->name . ' | ' . $owner->national_id . ' | ' . $owner->zip_code;
        }

        $date = Jalalian::now();

        $formatted_date = $date->format('d').$date->format('m').$date->getYear();

        return view('order.create')->with(['costumers' => $formatted_cos, 'costumer' => $costumer_id, 'trans' => $formatted_tran, 'owners' => $formatted_owners, 'date' => $formatted_date]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->authorize('create', Order::class);

        $this->validate($request,
            [
                'ordernum' => 'required|unique:orders,order_num,null,id,year_id,'.$request->input('year'),
                'costumer' => 'required',
                'transport' => 'required',
                'amount' => 'required',
                'date' => 'required|regex:/[0-9]{4}\/[0-9]{2}\/[0-9]{2}/',
                'owner' => 'required',
            ], 
            [
                'ordernum.required' => 'وارد کردن شماره حواله لازم است.',
                'ordernum.unique' => 'شماره حواله در سال مالی تکراری باشد.',
                'costumer.required' => 'وارد کردن مشتری لازم است.',
                'transport.required' => 'وارد کردن باربری لازم است.',
                'amount.required' => 'وارد کردن مقدار حواله لازم است.',
                'owner.required' => 'وارد کردن مالک لازم است.',
                'date.required' => 'وارد کردن تاریخ لازم است.',
                'date.regex' => 'تاریخ وارد شده صحیح نیست مثلا وارد کنید 1399/02/06',
            ]
        );

        $date = (new Jalalian(substr($request->input('date'),0,4), substr($request->input('date'),5,2), substr($request->input('date'),8,2)))->toCarbon()->toDateString();

        $order = new Order();

        $order->order_num = $request->input('ordernum');
        $order->amount = $request->input('amount');
        $order->description = $request->input('description');
        $order->date = $date;
        $order->costumer_id = $request->input('costumer');
        $order->transportation_id = $request->input('transport');
        $order->owner_id = $request->input('owner');
        $order->year_id = $request->input('year');
        
        if($request->input('create') === "ایجاد حواله") {
            $order->is_certain = 0;
        }

        $order->save();

        return redirect('orders')->with('success', 'حواله با موفقیت ذخیره گردید');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Order::class);

        $order = Order::find($id);

        $formatted_cos = [];
        $formatted_tran = [];
        $formatted_owners = [];

        $costumers = Costumer::all();
        $trans = Transportation::all();
        $owners = Owner::all();

        foreach($trans as $tran) {
            $formatted_tran[$tran->id] = $tran->name;
        }

        foreach ($costumers as $costumer) {
            $formatted_cos[$costumer->id] = $costumer->first_name . ' ' . $costumer->last_name . ' | ' . $costumer->national_code;
        }

        foreach ($owners as $owner) {
            $formatted_owners[$owner->id] = $owner->name . ' | ' . $owner->national_id . ' | ' . $owner->zip_code;
        }

        $date = Jalalian::forge($order->date)->format('%Y/%m/%d');

        $order->date = $date;

        return view('order.edit')->with(['order' => $order, 'costumers' => $formatted_cos, 'trans' => $formatted_tran, 'owners' => $formatted_owners]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', Order::class);
        $this->validate($request,
            [
                'ordernum' => 'required|unique:orders,order_num,'.$id,
                'costumer' => 'required',
                'transport' => 'required',
                'amount' => 'required',
                'date' => 'required|regex:/[0-9]{4}\/[0-9]{2}\/[0-9]{2}/',
                'owner' => 'required',
            ], 
            [
                'ordernum.required' => 'وارد کردن شماره حواله لازم است.',
                'ordernum.unique' => 'شماره حواله نباید تکراری باشد.',
                'costumer.required' => 'وارد کردن مشتری لازم است.',
                'transport.required' => 'وارد کردن باربری لازم است.',
                'amount.required' => 'وارد کردن مقدار حواله لازم است.',
                'owner.required' => 'وارد کردن مالک لازم است.',
                'date.required' => 'وارد کردن تاریخ لازم است.',
                'date.regex' => 'تاریخ وارد شده صحیح نیست مثلا وارد کنید 1399/02/06',
            ]
        );

        $date = (new Jalalian(substr($request->input('date'),0,4), substr($request->input('date'),5,2), substr($request->input('date'),8,2)))->toCarbon()->toDateString();

        $order = Order::find($id);

        $this->authorize('update', $order);

        $order->order_num = $request->input('ordernum');
        $order->amount = $request->input('amount');
        $order->description = $request->input('description');
        $order->date = $date;
        $order->costumer_id = $request->input('costumer');
        $order->transportation_id = $request->input('transport');
        $order->owner_id = $request->input('owner');
    
        $order->save();

        return redirect('orders')->with('success', 'حواله با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', Order::class);

        Order::destroy($request->input('orders'));

        return redirect('/orders')->with('success', 'حواله ها با موفقیت حذف شدند.');
    }

    /**
     * reporting from orders
     */

    public function report(Request $request) {
        $date = Jalalian::now()->format('%Y/%m/%d');

        $orders = [];

        foreach($request->input('orders') as $order_num) {
            array_push($orders, Order::find($order_num));
        }

        return view('order.report')->with(['orders' => $orders, 'date' => $date]);
    }


    public function generalReport(Request $request) {
        $this->authorize('viewAny', Order::class);
        $data = [];
        $owners = Owner::all();
        $costumers = Costumer::all();
        $rowspan = count($owners) + 1;
        $formatted_cos = [];
        $formatted_cos[''] = null;

        $start_date = null;
        $end_date = null;
        $costumer_name = null;

        foreach ($costumers as $costumer) {
            $formatted_cos[$costumer->id] = $costumer->first_name . ' ' . $costumer->last_name . ' | ' . $costumer->national_code;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // dd($request->all());
            if ($request->input('transportation')) {
                $transportations = Transportation::find(['0' => $request->input('transportation')]);
            } else {
                $transportations = Transportation::all();
            }

            if ($request->input('start')) {
                $start = (new Jalalian(substr($request->input('start'),0,4), substr($request->input('start'),5,2), substr($request->input('start'),8,2)))->toCarbon()->toDateString();
            } else {
                $start = DB::table('orders')->orderBy('date', 'asc')->first()->date;
            }

            if ($request->input('end')) {
                $end = (new Jalalian(substr($request->input('end'),0,4), substr($request->input('end'),5,2), substr($request->input('end'),8,2)))->toCarbon()->toDateString();
            } else {
                $end = DB::table('orders')->orderBy('date', 'desc')->first()->date;
            }

            if ($request->input('temporary')) {
                $certain = ['0', '1'];
            } else {
                $certain = ['1'];
            }

            // dd($certain);

            foreach ($transportations as $transporter) {
                $owners_arr = [];
                foreach ($owners as $owner) {
                    if ($request->input('costumer')) {
                        $costumer_name = Costumer::find($request->input('costumer'))->first_name . ' ' . Costumer::find($request->input('costumer'))->last_name;
                        $sum = DB::table('orders')->where([
                            ['transportation_id' , '=', $transporter->id],
                            ['owner_id', '=', $owner->id],
                            ['costumer_id', '=', $request->input('costumer')],
                            ['date', '>=', $start],
                            ['date', '<=', $end],
                        ])->whereIn('is_certain', $certain)->sum('amount');

                        $count = DB::table('orders')->where([
                            ['transportation_id' , '=', $transporter->id],
                            ['owner_id', '=', $owner->id],
                            ['costumer_id', '=', $request->input('costumer')],
                            ['date', '>=', $start],
                            ['date', '<=', $end],
                        ])->whereIn('is_certain', $certain)->count();
                    } else {
                        $sum = DB::table('orders')->where([
                            ['transportation_id' , '=', $transporter->id],
                            ['owner_id', '=', $owner->id],
                            ['date', '>=', $start],
                            ['date', '<=', $end],
                        ])->whereIn('is_certain', $certain)->sum('amount');

                        $count = DB::table('orders')->where([
                            ['transportation_id' , '=', $transporter->id],
                            ['owner_id', '=', $owner->id],
                            ['date', '>=', $start],
                            ['date', '<=', $end],
                        ])->whereIn('is_certain', $certain)->count();
                    }
                    $attr[0] = $count;
                    $attr[1] = $sum;
                    $owners_arr[$owner->name] = $attr;
                }

                $start_date = Jalalian::forge($start)->format('%Y/%m/%d');
                $end_date = Jalalian::forge($end)->format('%Y/%m/%d');

                $data[$transporter->name] = $owners_arr;
            };
        }
        
        return view('order.general', ['data' => $data, 'costumers' => $formatted_cos, 'start' => $start_date, 'end' => $end_date, 'rowspan' => $rowspan, 'costumer' => $costumer_name]);
    }

    public function viewed(Request $request) {
        $this->authorize('view', Order::class);
        $orders = Order::find($request->input('orders'))->where('is_viewed', '=', '0');
        $temporary = false;
        $message_type = 'success';
        $message = 'حواله ها به لیست رویت شده ها توسط باربری اضافه گردیدند.';

        foreach ($orders as $order) {
            if ($order->is_certain == 1) {
                $order->is_viewed = 1;
                $order->save();
            } else {
                $temporary = true;
            }
        }

        if ($temporary == true) {
            $message_type = 'fail';
            $message = 'بعضی از حواله ها موقت بودند و نمی توانند به لیست رویت شده ها اضافه گردند.';
        }

        return redirect('/orders')->with($message_type, $message);
    }

    public function unviewed(Request $request) {
        $orders = Order::find($request->input('orders'))->where('is_viewed', '=', '1');

        foreach ($orders as $order) {
            $order->is_viewed = 0;
            $order->save();
        }
        return redirect('/orders')->with('success', 'حواله های انتخاب شده از لیست تایید شده ها خارج گردیدند.');
    }

    public function certain(Request $request) {
        $this->authorize('create', Order::class);
        $orders = Order::find($request->input('orders'))->where('is_certain', '=', '0');

        foreach ($orders as $order) {
            $order->is_certain = 1;
            $order->save();
        }
        return redirect('/orders')->with('success', 'حواله ها برای باربری ها قابل رویت شدند.');
    }

    public function temporary(Request $request) {
        $this->authorize('create', Order::class);
        $orders = Order::find($request->input('orders'))->where('is_certain', '=', '1');
        $viewed = false;
        $message_type = 'success';
        $message = 'حواله ها از لیست قابل رویت باربری ها خارج شدند.';

        foreach ($orders as $order) {
            if ($order->is_viewed == 0) {
                $order->is_certain = 0;
                $order->save();
            } else {
                $viewed = true;
            }
        }

        if ($viewed == true) {
            $message_type = 'fail';
            $message = 'به نظر می رسید بعضی از حواله ها قبلا تایید شده بودند و خارج کردن آنها از لیست باربری ها انجام نشد.';
        }

        return redirect('/orders')->with($message_type, $message);
    }

    /**
     * retutn timestamp of date 
     */
    private function dateToTimestamp($date) {
        return (new Jalalian(substr($date,0,4), substr($date,5,2), substr($date,8,2)))->
        getTimestamp();
    }

    private function getOrders($request) {
        $start = $request->input('start');
        $end = $request->input('end');
        $transporter = $request->input('transporter');
        $owner = $request->input('owner');
    
        if (Auth::user()->transportation_id) {
            $certain = ['1'];
        } else {
            $certain = ['0', '1'];
        }

        if ($start) {
            $start = (new Jalalian(substr($request->input('start'),0,4), substr($request->input('start'),5,2), substr($request->input('start'),8,2)))->toCarbon()->toDateString();
        }

        if ($end) {
            $end = (new Jalalian(substr($request->input('end'),0,4), substr($request->input('end'),5,2), substr($request->input('end'),8,2)))->toCarbon()->toDateString();
        }

        switch (true) {
            case ($start == null && $end == null && $transporter == null && $owner == null):
                $orders = Order::orderBy('order_num', 'desc')->whereIn('is_certain', $certain)->get();
                break;
            case ($start == null && $end == null && $transporter == null && $owner != null):
                $orders = Order::where([
                    ['owner_id', '=', $owner],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;
            case ($start == null && $end == null && $transporter != null && $owner == null):
                $orders = Order::where([
                    ['transportation_id', '=', $transporter],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;  
            case ($start == null && $end == null && $transporter != null && $owner != null):
                $orders = Order::where([
                    ['owner_id', '=', $owner],
                    ['transportation_id', '=', $transporter],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;  
            case ($start == null && $end != null && $transporter == null && $owner == null):
                $orders = Order::where([
                    ['date', '<=', $end],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;    
            case ($start == null && $end != null && $transporter == null && $owner != null):
                $orders = Order::where([
                    ['date', '<=', $end],
                    ['owner_id', '=', $owner],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break; 
            case ($start == null && $end != null && $transporter != null && $owner == null):
                $orders = Order::where([
                    ['date', '<=', $end],
                    ['transportation_id', '=', $transporter],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;        
            case ($start == null && $end != null && $transporter != null && $owner != null):
                $orders = Order::where([
                    ['date', '<=', $end],
                    ['transportation_id', '=', $transporter],
                    ['owner_id', '=', $owner],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;
            case ($start != null && $end == null && $transporter == null && $owner == null):
                $orders = Order::where([
                    ['date', '>=', $start],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;
            case ($start != null && $end == null && $transporter == null && $owner != null):
                $orders = Order::where([
                    ['date', '>=', $start],
                    ['owner_id', '=', $owner],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;
            case ($start != null && $end == null && $transporter != null && $owner == null):
                $orders = Order::where([
                    ['date', '>=', $start],
                    ['transportation_id', '=', $transporter],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;
            case ($start != null && $end == null && $transporter != null && $owner != null):
                $orders = Order::where([
                    ['date', '>=', $start],
                    ['transportation_id', '=', $transporter],
                    ['owner_id', '=', $owner],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;
            case ($start != null && $end != null && $transporter == null && $owner == null):
                $orders = Order::where([
                    ['date', '>=', $start],
                    ['date', '<=', $end],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;
            case ($start != null && $end != null && $transporter == null && $owner != null):
                $orders = Order::where([
                    ['date', '>=', $start],
                    ['date', '<=', $end],
                    ['owner_id', '=', $owner],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;
            case ($start != null && $end != null && $transporter != null && $owner == null):
                $orders = Order::where([
                    ['date', '>=', $start],
                    ['date', '<=', $end],
                    ['transportation_id', '=', $transporter],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;
            case ($start != null && $end != null && $transporter != null && $owner != null):
                $orders = Order::where([
                    ['date', '>=', $start],
                    ['date', '<=', $end],
                    ['transportation_id', '=', $transporter],
                    ['owner_id', '=', $owner],
                ])->whereIn('is_certain', $certain)->orderBy('order_num', 'desc')->get();
                break;
        }

        return $orders;
    }
}
