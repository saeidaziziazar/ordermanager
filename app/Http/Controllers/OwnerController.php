<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;

class OwnerController extends Controller
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
        $owners = Owner::all();

        $this->authorize('view', $owners[0]);

        return view('owner.index')->with('owners', $owners);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Owner::class);

        return view('owner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Owner::class);

        $this->validate($request, [
            'name' => 'required|unique:owners,name',
            'nationalcode' => 'required|unique:owners,national_id|digits_between:10,11',
            'zipcode' => 'required|unique:owners,zip_code|digits:10',
        ],[
            
            'name.required' => 'پر کردن نام لازم است',
            'name.unique' => 'نام تکراری می باشد.',
            'nationalcode.required' => 'پر کردن شناسه ملی لازم است',
            'nationalcode.digits_between' => 'کد (شناسه) ملی باید 10 یا 11 رقم باشد',
            'nationalcode.unique' => 'کد (شناسه) ملی تکراری می باشد',
            'zipcode.required' => 'پر کردن کد پستی لازم است',
            'zipcode.digits' => 'کد پستی باید ده رقم باشد',
            'zipcode.unique' => 'کد پستی تکراری می باشد.',
        ]);

        $owner = new Owner();
        $owner->name = $request->input('name');
        $owner->national_id = $request->input('nationalcode');
        $owner->zip_code = $request->input('zipcode');

        $owner->save();

        return redirect('/owners')->with('success', 'مالک با موفقیت ذخیره شد');
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
        $owner = Owner::find($id);

        $this->authorize('update', $owner);

        return view('owner.edit')->with('owner', $owner);
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
        // dd($request->input('name'));
        $this->validate($request, [
            'name' => 'required|unique:owners,name,'.$id,
            'nationalcode' => 'required|digits_between:10,11|unique:owners,national_id,'.$id,
            'zipcode' => 'required|digits:10|unique:owners,zip_code,'.$id,
        ],[
            
            'name.required' => 'پر کردن نام لازم است',
            'name.unique' => 'نام تکراری می باشد.',
            'nationalcode.required' => 'پر کردن شناسه ملی لازم است',
            'nationalcode.digits_between' => 'کد (شناسه) ملی باید 10 یا 11 رقم باشد',
            'nationalcode.unique' => 'کد (شناسه) ملی تکراری می باشد',
            'zipcode.required' => 'پر کردن کد پستی لازم است',
            'zipcode.digits' => 'کد پستی باید ده رقم باشد',
            'zipcode.unique' => 'کد پستی تکراری می باشد.',
        ]);

        $owner = Owner::find($id);

        $this->authorize('update', $owner);

        $owner->name = $request->input('name');
        $owner->national_id = $request->input('nationalcode');
        $owner->zip_code = $request->input('zipcode');

        $owner->save();

        return redirect('/owners')->with('success', 'مالک با موفقیت ذخیره شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->input('owners')) {
            return redirect('/owners')->with('fail', 'حداقل یک  مورد باید انتخاب شود.');
        } else {
            $this->authorize('delete', Owner::find($request->input('owners')[0]));
            Owner::destroy($request->input('owners'));
            return redirect('/owners')->with('success', 'مشتری ها با موفقیت حذف شدند');
        }
    }
}
