<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Costumer;

class CostumerController extends Controller
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
        $costumers = Costumer::orderBy('id', 'desc')->get();

        $this->authorize('view', $costumers[0]);

        return view('costumer.index')->with('costumers', $costumers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Costumer::class);

        return view('costumer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->authorize('create', Costumer::class);

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'cellphonenum[]' => 'required|regex:/(09)[0-9]{9}/',
            'nationalcode' => 'unique:costumers,national_code|digits_between:10,11',
            'zipcode[]' => 'nullable|digits:10',
            'address[]' => 'required',
            'addressname[]' => 'required',
        ],[
            
            'firstname.required' => 'پر کردن نام لازم است',
            'lastname.required' => 'پر کردن نام خانوادگی لازم است',
            'zipcode.digits' => 'در صورت وارد کردن کد پستی باید ده رقم باشد',
            'nationalcode.digits_between' => 'کد (شناسه) ملی باید 10 یا 11 رقم باشد',
            'nationalcode.unique' => 'کد (شناسه) ملی تکراری می باشد',
            'cellphonenum.required' => 'وارد کردن شماره تلفن همراه ضروری می باشد.',
            'cellphonenum.regex' => 'شماره تلفن وارد شده صحیح نمی باشد',
            'address.required' => 'وارد کردن آدرس ضروری می باشد',
        ]);

        $costumer = new Costumer();

        $costumer->first_name = $request->input('firstname');
        $costumer->last_name = $request->input('lastname');
        $costumer->description = $request->input('description');
        $costumer->national_code = $request->input('nationalcode');
        $costumer->cell_phone_num = $request->input('cellphonenum');
        $costumer->phone_num = $request->input('phonenum');
        $costumer->zip_code = $request->input('zipcode');
        $costumer->address = $request->input('address');

        $costumer->save();

        return redirect('/costumers')->with('success', 'مشتری با موفقیت ذخیره شد');
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
        $costumer = Costumer::find($id);

        $this->authorize('update', $costumer);

        return view('costumer.edit')->with('costumer', $costumer);
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
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'cellphonenum' => 'required|regex:/(09)[0-9]{9}/',
            'nationalcode' => 'digits_between:10,11|unique:costumers,national_code,'.$id,
            'zipcode' => 'nullable|digits:10',
            'address' => 'required',
        ],[
            
            'firstname.required' => 'پر کردن نام لازم است',
            'lastname.required' => 'پر کردن نام خانوادگی لازم است',
            'zipcode.digits' => 'در صورت وارد کردن کد پستی باید ده رقم باشد',
            'nationalcode.digits_between' => 'کد (شناسه) ملی باید 10 یا 11 رقم باشد',
            'nationalcode.unique' => 'کد (شناسه) ملی تکراری می باشد',
            'cellphonenum.required' => 'وارد کردن شماره تلفن همراه ضروری می باشد.',
            'cellphonenum.regex' => 'شماره تلفن وارد شده صحیح نمی باشد',
            'address.required' => 'وارد کردن آدرس ضروری می باشد',
        ]);

        $costumer = Costumer::find($id);

        $this->authorize('update', $costumer);

        $costumer->first_name = $request->input('firstname');
        $costumer->last_name = $request->input('lastname');
        $costumer->description = $request->input('description');
        $costumer->national_code = $request->input('nationalcode');
        $costumer->cell_phone_num = $request->input('cellphonenum');
        $costumer->phone_num = $request->input('phonenum');
        $costumer->zip_code = $request->input('zipcode');
        $costumer->address = $request->input('address');

        $costumer->save();

        return redirect('/costumers')->with('success', 'مشتری با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', Costumer::find($request->input('costumers')[0]));

        Costumer::destroy($request->input('costumers'));

        return redirect('/costumers')->with('success', 'مشتری ها با موفقیت حذف شدند');
    }
}
