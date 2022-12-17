<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aryUser = User::paginate(5);
        return view('admin/users/list', compact('aryUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/users/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|required_with:re_password|same:re_password',
                're_password' => 'min:6|required',
            ],
            [
                'required' => 'Trường :attribute không được để trống!',
                'min' => 'Trường :attribute phải có tối thiểu :min kí tự',
                'max'=> 'Trường :attribute chỉ tối đa :max kí tự',
                'same' => ':attribute và :other không khớp nhau',
                'required_with' => 'Mật khẩu không được để trống',
            ]
        );

        if ($validator->fails()) {
            return redirect(route('create.users'))->withErrors($validator)->withInput($request->all());
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);

        session()->flash('create_user', 'success');
        return redirect(route('list.users'));
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
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|min:3',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'required|min:6|required_with:re_password|same:re_password',
                're_password' => 'min:6|required',
            ],
            [
                'required' => 'Trường :attribute không được để trống!',
                'min' => 'Trường :attribute phải có tối thiểu :min kí tự',
                'max'=> 'Trường :attribute chỉ tối đa :max kí tự',
                'same' => ':attribute và :other không khớp nhau',
                'required_with' => 'Mật khẩu không được để trống',
            ]
        );

        if ($validator->fails()) {
            return redirect(route('edit.users', $id))->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        if ($user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            session()->flash('edit_user', 'success');
            return redirect(route('list.users'));
        }
        session()->flash('user_not_exist', 'fail');
        return redirect(route('list.users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            session()->flash('delete_user', 'success');
            return redirect(route('list.users'));
        }
        session()->flash('user_not_exist', 'fail');
        return redirect(route('list.users'));
    }
}
