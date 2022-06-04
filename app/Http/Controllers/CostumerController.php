<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Costumer;
use App\Address;
use App\Order;

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

        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'nationalcode' => 'unique:costumers,national_code|digits_between:10,11',
            'addressname.*' => 'required',
            'address.*' => 'required',
            'cellphonenum.*' => 'nullable|regex:/(09)[0-9]{9}/',
            'zipcode.*' => 'nullable|digits:10',
        ];

        $messages = [
            
            'firstname.required' => 'پر کردن نام لازم است',
            'lastname.required' => 'پر کردن نام خانوادگی لازم است',
            'nationalcode.digits_between' => 'کد (شناسه) ملی باید 10 یا 11 رقم باشد',
            'nationalcode.unique' => 'کد (شناسه) ملی تکراری می باشد',
        ];

        foreach ($request->get('addressname') as $key => $value) {
            $index = $key + 1;
            $messages['addressname.'.$key.'.required'] = "عنوان آدرس ".$index." را پر کنید";
        }

        foreach ($request->get('address') as $key => $value) {
            $index = $key + 1;
            $messages['address.'.$key.'.required'] = "آدرس ".$index." را پر کنید";
        }

        foreach ($request->get('cellphonenum') as $key => $value) {
            $index = $key + 1;
            $messages['cellphonenum.'.$key.'.required'] = "شماره تلفن آدرس ".$index." را پر کنید";
        }

        foreach ($request->get('cellphonenum') as $key => $value) {
            $index = $key + 1;
            $messages['cellphonenum.'.$key.'.regex'] = "شماره تلفن آدرس ".$index." اشتباه می باشد";
        }

        foreach ($request->get('zipcode') as $key => $value) {
            $index = $key + 1;
            $messages['zipcode.'.$key.'.digits'] = "کد پستی آدرس ".$index." اشتباه می باشد";
        }

        $this->validate($request, $rules, $messages);

        $costumer = new Costumer();

        $costumer->first_name = $request->input('firstname');
        $costumer->last_name = $request->input('lastname');
        $costumer->description = $request->input('description');
        $costumer->national_code = $request->input('nationalcode');
        $costumer->phone_num = $request->input('phonenum');

        $costumer->save();

        for ($i=0; $i < count($request->get('address')); $i++) { 
            $address = new Address();

            if ($i == $request->get('is_default')) $address['is_default'] = 1;

            $address['name'] = $request->get('addressname')[$i];
            $address['phone_number'] = $request->get('cellphonenum')[$i];
            $address['zip_code'] = $request->get('zipcode')[$i];
            $address['address'] = $request->get('address')[$i];

            $costumer->addresses()->save($address);
        }

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
        $addresses = $costumer->addresses()->get()->toArray();
        foreach ($addresses as &$address) {
            
            if (Order::where('address_id', $address['id'])->first()) {
                $address['disabled'] = true;
            } else {
                $address['disabled'] = false;
            }
        }

        // dd($addresses);
        $this->authorize('update', $costumer);

        $url = 'orders/create/' . $costumer->id;

        return view('costumer.edit')->with(['costumer' => $costumer, 'addresses' => $addresses, 'url' => $url]);
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
            'firstname' => 'required',
            'lastname' => 'required',
            'nationalcode' => 'digits_between:10,11|unique:costumers,national_code,'.$id,
            'addressname.*' => 'required',
            'address.*' => 'required',
            'cellphonenum.*' => 'nullable|regex:/(09)[0-9]{9}/',
            'zipcode.*' => 'nullable|digits:10',
        ];

        $messages = [
            
            'firstname.required' => 'پر کردن نام لازم است',
            'lastname.required' => 'پر کردن نام خانوادگی لازم است',
            'nationalcode.digits_between' => 'کد (شناسه) ملی باید 10 یا 11 رقم باشد',
            'nationalcode.unique' => 'کد (شناسه) ملی تکراری می باشد',
        ];

        foreach ($request->get('addressname') as $key => $value) {
            $index = $key + 1;
            $messages['addressname.'.$key.'.required'] = "عنوان آدرس ".$index." را پر کنید";
        }

        foreach ($request->get('address') as $key => $value) {
            $index = $key + 1;
            $messages['address.'.$key.'.required'] = "آدرس ".$index." را پر کنید";
        }

        foreach ($request->get('cellphonenum') as $key => $value) {
            $index = $key + 1;
            $messages['cellphonenum.'.$key.'.required'] = "شماره تلفن آدرس ".$index." را پر کنید";
        }

        foreach ($request->get('cellphonenum') as $key => $value) {
            $index = $key + 1;
            $messages['cellphonenum.'.$key.'.regex'] = "شماره تلفن آدرس ".$index." اشتباه می باشد";
        }

        foreach ($request->get('zipcode') as $key => $value) {
            $index = $key + 1;
            $messages['zipcode.'.$key.'.digits'] = "کد پستی آدرس ".$index." اشتباه می باشد";
        }

        $this->validate($request, $rules, $messages);

        $costumer = Costumer::find($id);

        $this->authorize('update', $costumer);

        $costumer->first_name = $request->input('firstname');
        $costumer->last_name = $request->input('lastname');
        $costumer->description = $request->input('description');
        $costumer->national_code = $request->input('nationalcode');
        $costumer->phone_num = $request->input('phonenum');

        Address::where('costumer_id', $costumer->id)->whereNotIn('id', $request->get('id'))->delete();
        
        $costumer->save();
        
        for ($i=0; $i < count($request->get('id')); $i++) { 
            if (is_null($request->get('id')[$i])) {
                $address = new Address();

                if ($request->get('default')[0] == $i) $address['is_default'] = 1;

                $address['name'] = $request->get('addressname')[$i];
                $address['phone_number'] = $request->get('cellphonenum')[$i];
                $address['zip_code'] = $request->get('zipcode')[$i];
                $address['address'] = $request->get('address')[$i];

                $costumer->addresses()->save($address);
            } else {
                $address = Address::find($request->get('id')[$i]);
                
                $address['is_default'] = 0;
                if ($request->get('default')[0] == $i) {
                    $address['is_default'] = 1;
                }

                $address['name'] = $request->get('addressname')[$i];
                $address['phone_number'] = $request->get('cellphonenum')[$i];
                $address['zip_code'] = $request->get('zipcode')[$i];
                $address['address'] = $request->get('address')[$i];

                // dd($address);

                $address->save();
            }
        }

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

        if (!$request->input('costumers')) {
            return redirect('/costumers')->with('fail', 'حداقل یک  مورد باید انتخاب شود.');
        } else {
            $this->authorize('delete', Costumer::find($request->input('costumers')[0]));
            try {
                Costumer::destroy($request->input('costumers'));
            } catch (\Illuminate\Database\QueryException $ًQexception) {
                return redirect('/costumers')->with('fail', 'برای این مشتری ها قبلا حواله ثبت شده است و امکان حذف وجود ندارد');
            }
            
            return redirect('/costumers')->with('success', 'مشتری ها با موفقیت حذف شدند');
        }
    }
}
