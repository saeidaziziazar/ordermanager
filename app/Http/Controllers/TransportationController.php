<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transportation;

class TransportationController extends Controller
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
        $trans = Transportation::all();

        $this->authorize('view', $trans[0]);

        return view('transportation.index')->with('trans', $trans);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Transportation::class);

        return view('transportation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Transportation::class);

        $rules = [
            'name' => 'required|unique:transportations,name', 
            'manager' => 'required',
        ];

        $messages = [
            'name.required' => 'وارد کردن نام باربری لازم می باشد',
            'name.unique' => 'نام باربری تکراری می باشد.',
            'manager.required' => 'وارد کردن نام مدیر لازم می باشد',
        ];

        $this->validate($request, $rules, $messages);

        $trans = new Transportation();
        $trans->name = $request->input('name');
        $trans->manager = $request->input('manager');

        $trans->save();

        return redirect('/transportations')->with('success', 'باربری با موفقیت ذخیره شد');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // has no show class

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trans = Transportation::find($id);

        $this->authorize('update', $trans);

        return view('transportation.edit')->with('trans', $trans);
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
        $rules = [
            'name' => 'required|unique:transportations,name,'.$id, 
            'manager' => 'required',
        ];

        $messages = [
            'name.required' => 'وارد کردن نام باربری لازم می باشد',
            'name.unique' => 'نام باربری تکراری می باشد.',
            'manager.required' => 'وارد کردن نام مدیر لازم می باشد',
        ];

        $this->validate($request, $rules, $messages);

        $trans = Transportation::find($id);

        $this->authorize('update', $trans);

        $trans->name = $request->input('name');
        $trans->manager = $request->input('manager');

        $trans->save();

        return redirect('/transportations')->with('success', 'باربری با موفقیت ذخیره شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', Transportation::find($request->input('trans')[0]));

        Transportation::destroy($request->input('trans'));

        return redirect('/transportations')->with('success', 'حواله ها با موفقیت حذف شد');
    }
}
