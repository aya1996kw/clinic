<?php

namespace App\Http\Controllers;
use  App\Models\user;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
class UsersController extends Controller
{

    function login_index(){
    return view('login',['error' =>'']);
    }
    function register_index(){
    return view('register',['error' =>'']);
    }

    function login(Request $request){

    $user=User::where('email',$request['email'])->count();
    if($user == 0)
    return view('login',['error' => " This email doesn't exists"]);
    $email = $request->input('email');
    $password = $request->input('password');
    if(Auth::attempt(['email' => $email, 'password' => $password]))
    {
        if (Auth::user()->role ==1){
            return redirect('/doctor/home');
        }
        elseif(Auth::user()-> role ==2){
            return redirect('/admin/home');
        }
        elseif(Auth::user()->role ==0) {
            return redirect('/home');
        }
    }
        return view('login',['error' => " Invalid Credintials"]);
    }

    function register(Request $request){
    $user = User::where('email',$request['email'])->count();
    if(!isset($request['name']) ||!isset($request['email'])
    ||($request['name']) == "" || ($request['email']) == ""
    ||!isset($request['password']) || ($request['password']) == "" )
    return view('register',['error' => "somthing wrong"]);
    if($user > 0)
    return view('register',['error' => " This email doesn't exists"]);
    User::create([
        'name' => $request ['name'],
        'email' =>$request ['email'],
        'password' => Hash::make($request['password']),
        'role' => 0,
        'duration'=>0,

    ]);
    return view('login',['error' => '']);
    }

    public function logout(){
    Session::flush();
      Auth::logout();
      return redirect('login');

    }
   
    }


