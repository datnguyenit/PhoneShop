<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\roles;  
use App\bills;  
use Illuminate\Support\Facades\Input;
// use Response;
class AdminController extends Controller
{
    //log in
    public function postLogin(Request $request){
    	$email = $request->get('email');
    	$password = $request->get('password');

    	if(Auth::attempt(['email'=>$email,'password'=>$password])){
    		return redirect()->route('getadminindex');
    	}
    	return redirect()->route('login')->withInput()->with('mess','Nhập sai tài khoản hoặc password');
    }

    //logout
    public function getLogout(){
    	Auth::logout();
    	return redirect()->route('login');
    }
    public function getIndex(){
    	return view('admin.page.index');
    }

    //User
    public function getListUser(){
        $users = User::get();
        return view('admin.page.user.listuser',compact('users'));
    }
        //create user using GET
    public function getCreateUser(){
        $roles = roles::get();
        return view('admin.page.user.createuser',compact('roles'));
    }
        //create user using POST
    public function postCreateUser(Request $request){
        //check email unique
        if($this->checkEmail($request->get('email'))) return redirect()->back()->withInput()->with(['mess'=>'Create user failed! Email has used','style'=>'danger']);

        try{
            $user = new User();
            $user->name=$request->get('name');
            $user->email=$request->get('email');
            $user->password= bcrypt($request->get('password'));
            $user->phone=$request->get('phone');
            $user->role_id=$request->get('role_id');
            $user->status=$request->get('status');
            $user->save();
        }catch(\Exception $e){
            // console.log($e);
            return redirect()->back()->withInput()->with(['mess'=>'Create user failed','style'=>'danger']);

        }
        return redirect()->back()->with(['mess'=>'Create user successful','style'=>'success']);

    }

    public function getCheckEmail(){
        $email = Input::get('email');
         if($this->checkEmail($email)) {
            return response()->json('Email has already been taken');
         }
         return response()->json('true');
    }

    //public check Email has created
    public function checkEmail($email){
        return (User::where('email',$email)->first())?true:false;
    }
    

    public function getEditUser($id){
        $roles = roles::get();
        $user = User::findOrFail($id);
        return view('admin.page.user.edituser',compact('user','roles'));
    }
    public function postEditUser(Request $request){
        $user=User::findOrFail($request->id);
        if(!$user){
            return redirect()->back()->withInput()->with(['mess'=>'Edit user failed','style'=>'danger']);
        }
        if($this->checkEmail($request->get('email')) && $request->get('email')!= $user->email) return redirect()->back()->withInput()->with(['mess'=>'Edit user failed! Email has used','style'=>'danger']);
        try{
            $user->name=$request->get('name');
            $user->email=$request->get('email');
            if($request->get('edit_password') == true){
                 $user->password= bcrypt($request->get('password'));
            }    
            $user->phone=$request->get('phone');
            $user->role_id=$request->get('role_id');
            $user->status=$request->get('status');
            $user->save();
             return redirect()->back()->with(['mess'=>'Edit user successful','style'=>'success']);
        }catch(\Exception $e){
            return redirect()->back()->withInput()->with(['mess'=>'Edit user failed from try catch','style'=>'danger']);
        }
    }
    //function delete user
    public function getDeleteUser($id){
        $user = User::findOrFail($id);
        try{
            $user->delete();
            return redirect()->back()->with(['mess'=>'Delete user successful','style'=>'success']);
        }catch(\Exception $e){
            return redirect()->back()->withInput()->with(['mess'=>'Delete user failed from try catch','style'=>'danger']);
        }
    }






   
}	
