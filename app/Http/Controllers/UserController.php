<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $data = User::get();
        return view('projects.users.index',['data'=>$data]);
    }

    public function add(){
        return view('projects.users.add');
    }

    public function create(Request $request){
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->user_role = 'client';
        if($data->save()){
            return redirect()->route('users.index')->with(['success' => 'تم اضافة المستخدم بنجاح']);
        }
    }

    public function edit($id){
        $data = User::where('id',$id)->first();
        return view('projects.users.edit',['data'=>$data]);
    }

    public function update(Request $request){
        $data = User::where('id',$request->id)->first();
        $data->name = $request->name;
        $data->email = $request->email;
        if($request->filled('password')){
            $data->password = Hash::make($request->password);
        }
        if($data->save()){
            return redirect()->route('users.index')->with(['success' => 'تم تعديل البيانات بنجاح']);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }
}
