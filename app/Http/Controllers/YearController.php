<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Year;
use Morilog\Jalali\Jalalian;

class YearController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years = Year::all();
        
        $this->authorize('all', $years[0]);

        foreach ($years as $year) {
            $year->start = Jalalian::forge($year->start)->format('%Y/%m/%d');
            $year->end = Jalalian::forge($year->end)->format('%Y/%m/%d');
        }

        return view('year.index')->with('years', $years);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('all', Auth::user(), Year::class);
        return view('year.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('all', Auth::user(), Year::class);
        
        $this->validate($request, [
            'name' => 'required|unique:years,name',
            'startdate' => 'required|regex:/[0-9]{4}\/[0-9]{2}\/[0-9]{2}/',
            'enddate' => 'required|regex:/[0-9]{4}\/[0-9]{2}\/[0-9]{2}/',
        ],[
            'name.required' => 'پر کردن نام لازم است',
            'name.unique' => 'نام تکراری می باشد',
            'startdate.required' => 'وارد کردن تاریخ شروع لازم است',
            'enddate.required' => 'وارد کردن تاریخ پایان لازم است',
            'startdate.regex' => 'تاریخ شروع وارد شده صحیح نیست مثلا وارد کنید 1399/02/06',
            'enddate.regex' => 'تاریخ پایان وارد شده صحیح نیست مثلا وارد کنید 1399/02/06',
        ]);

        $startdate = (new Jalalian(substr($request->input('startdate'),0,4), substr($request->input('startdate'),5,2), substr($request->input('startdate'),8,2)))->toCarbon()->toDateString();

        $enddate = (new Jalalian(substr($request->input('enddate'),0,4), substr($request->input('enddate'),5,2), substr($request->input('enddate'),8,2)))->toCarbon()->toDateString();
        
        if ($startdate < $enddate) {
            $years = Year::all();
            
            foreach ($years as $year) {
                if ($startdate < $year->end && $enddate > $year->start) {
                    return back()->with('fail', 'تاریخ انتخابی با سال مال دیگری تداخل دارد')->withInput();
                }
            }
        } else {
            return back()->with('fail', 'تاریخ شروع باید کوچکتر از تاریخ پایان باشد')->withInput();
        }

        $year = new Year();

        $year->name = $request->input('name');
        $year->start = $startdate;
        $year->end = $enddate;

        $year->save();

        return redirect('years')->with('success', 'سال مالی با موفقیت ذخیره گردید');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('all', Auth::user(), Year::class);
        $year = Year::find($id);
        $year->start = Jalalian::forge($year->start)->format('%Y/%m/%d');
        $year->end = Jalalian::forge($year->end)->format('%Y/%m/%d');
        
        return view('year.edit')->with('year', $year);
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
        $this->authorize('all', Auth::user(), Year::class);
        
        $this->validate($request, [
            'name' => 'required|unique:years,name,'.$id,
            'startdate' => 'required|regex:/[0-9]{4}\/[0-9]{2}\/[0-9]{2}/',
            'enddate' => 'required|regex:/[0-9]{4}\/[0-9]{2}\/[0-9]{2}/',
        ],[
            'name.required' => 'پر کردن نام لازم است',
            'name.unique' => 'نام تکراری می باشد',
            'startdate.required' => 'وارد کردن تاریخ شروع لازم است',
            'enddate.required' => 'وارد کردن تاریخ پایان لازم است',
            'startdate.regex' => 'تاریخ شروع وارد شده صحیح نیست مثلا وارد کنید 1399/02/06',
            'enddate.regex' => 'تاریخ پایان وارد شده صحیح نیست مثلا وارد کنید 1399/02/06',
        ]);

        $startdate = (new Jalalian(substr($request->input('startdate'),0,4), substr($request->input('startdate'),5,2), substr($request->input('startdate'),8,2)))->toCarbon()->toDateString();

        $enddate = (new Jalalian(substr($request->input('enddate'),0,4), substr($request->input('enddate'),5,2), substr($request->input('enddate'),8,2)))->toCarbon()->toDateString();

        if ($startdate < $enddate) {
            $conflict = false;
            $years = Year::all();
            
            foreach ($years as $year) {

                if ($year->id != $id && ($startdate < $year->end && $enddate > $year->start)) {
                    return back()->with('fail', 'تاریخ انتخابی با سال مال دیگری تداخل دارد')->withInput();
                }
            }
        } else {
            return back()->with('fail', 'تاریخ شروع باید کوچکتر از تاریخ پایان باشد')->withInput();
        }

        $year = Year::find($id);

        $year->name = $request->input('name');
        $year->start = $startdate;
        $year->end = $enddate;

        $year->save();

        return redirect('years')->with('success', 'سال مالی با موفقیت ویرایش گردید');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('all', Year::find($request->input('id')));
        try {
            Year::destroy($request->input('id'));
        } catch (\Illuminate\Database\QueryException $ًQexception) {
            return redirect('/years')->with('fail', 'برای این سال قبلا حواله ثبت شده است و امکان حذف وجود ندارد');
        }
        
        return redirect('/years')->with('success', 'سال انتخاب شده با موفقیت حذف شدند');
    }

    public function changeUserYear(Request $request) {
        $user = Auth::user();
        $user->year_id = $request->input('year');
        $user->save();
        return redirect('/');
    }
}
