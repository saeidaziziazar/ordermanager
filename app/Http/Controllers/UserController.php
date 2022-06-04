<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Crypt;
use Hash;
use Auth;
use App\User;
use App\Permission;
use App\Transportation;

class UserController extends Controller
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
        $users = User::all();

        $this->authorize('all', $users[0]);

        return view('user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('all', User::class);

        $permissions = Permission::all();
        $transportations = Transportation::all();

        $formatted_tran = [
            '' => 'کارخانه قند هکمتان',
        ];

        foreach($transportations as $transportation) {
            $formatted_tran[$transportation->id] = $transportation->name;
        }

        return view('user.create')->with(['permissions' => $permissions, 'tarnsportations' => $formatted_tran]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('all', User::class);

        $this->validate($request,[
            'password' => 'required|confirmed',
        ]);

        $user = new User();

        if ($request->input('status') === null) {
            $user->is_active = 0;
        } else {
            $user->is_active = 1;
        }

        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->transportation_id = $request->input('transport');

        $user->save();

        $user->permissions()->attach($request->input('permissions'));

        return redirect('\users')->with('success', 'کاربر با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        $this->authorize('all', User::class, $user);

        $permissions = Permission::all();
        $transportations = Transportation::all();

        $user = User::find($id);

        $user_permissions = [];

        $formatted_tran = [
            '' => 'کارخانه قند هکمتان',
        ];

        foreach($transportations as $transportation) {
            $formatted_tran[$transportation->id] = $transportation->name;
        }

        foreach ($user->permissions as $permission) {
            $user_permissions[] = $permission->id;
        }

        return view('user.edit')->with(['permissions' => $permissions, 'user' => $user, 'user_permissions' => $user_permissions, 'transportations' => $formatted_tran]);
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
            $this->validate($request,
                [
                    'password' => 'confirmed',
                ],
                [
                    'password.confirmed' => 'رمز عبور را صحیح وارد کنید',
                ]
            );

            $user = User::find($id);

            $this->authorize('all', $user);

            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->transportation_id = $request->input('transport');

            if ($request->input('password') === null) {
                // null
            } else {
                $user->password = Hash::make($request->input('password'));
            }

            if ($request->input('status') === null) {
                $user->is_active = 0;
            } else {
                $user->is_active = 1;
            }
            
            $user->save();

            $user->permissions()->sync($request->input('permissions'));

            return redirect('\users')->with('success', 'کاربر با موفقیت ویرایش گردید');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->input('users')) {
            return redirect('/users')->with('fail', 'حداقل یک  مورد باید انتخاب شود.');
        } else {
            $this->authorize('all', User::find($request->input('users')[0]));
            try {
                User::destroy($request->input('users'));
            } catch (\Illuminate\Database\QueryException $ًQexception) {
                return redirect('/users')->with('fail', 'امکان حذف کاربران وجود ندارد');
            }
            
            return redirect('/users')->with('success', 'مشتری ها با موفقیت حذف شدند');
        }
    }

    public function acount(Request $request) 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validate($request,
                [
                    'password' => 'confirmed|required',
                ],
                [
                    'password.confirmed' => 'رمز عبور را صحیح وارد کنید',
                    'password.required' => 'رمز عبور جدید را وارد نمایید'
                ]
            );

            $credentials = [
                'username' => Auth::user()->username,
                'password' => $request->input('oldpassword'),
            ];
    
            $attempt = Auth::once($credentials);

            if ($attempt) {
                Auth::user()->password = Hash::make($request->input('password'));
                if (Auth::user()->save()) {
                    Auth::logout();

                    return redirect('/login')->with('success', 'رمز عبور تغییر داده شد لطفا مجدد وارد شوید.');
                }
                
            } else {
                return redirect()->back()->with('error', 'رمز عبور اشتباه می باشد.');
            }
        }

        $user = Auth::user();

        return view('user.acount')->with('user', $user);
    }
}
