<?php

namespace App\Http\Controllers;
use  App\Models\specialization;
use App\Models\User;
use App\Models\Date;
use App\Models\Doctor_specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    public function table_doctor_index(){

        $doctors= User::where('role',1)->get();
        $Patient=User::where('role',0)->get();
        return view ('/admin/table_doctor',['doctors'=> $doctors]);
      }


    public function dashboard_index(){
      $doctors=User::where('role',1)->get();
      $Patient=User::where('role',0)->get();
      return view ('/admin/home',['doctors'=>$doctors],['Patient'=>$Patient]);
    }
    public function edit_index(){
         return view('edit', compact('student'));
        $doctors=User::where('role',1)->get();
        $Patient=User::where('role',0)->get();
    return view ('/admin/edit',['doctors'=>$doctors],['Patient'=>$Patient]);
  }
    public function Patient_index(){
        $doctors=User::where('role',1)->get();
        $Patient=User::where('role',0)->get();
    return view ('/admin/Patient',['doctors'=>$doctors],['Patient'=>$Patient]);
  }
        public function doctor_index(){
            $doctors=User::where('role',1)->get();
            $Patient=User::where('role',0)->get();
        return view ('/admin/doctor',['doctors'=>$doctors],['Patient'=>$Patient]);
      }
      public function specializations_index(){
        $doctors=User::where('role',1)->get();
        $Patient=User::where('role',0)->get();
        return view ('/admin/specializations',['doctors'=>$doctors],['Patient'=>$Patient]);
      }
    public function add_specializations(Request $request){
        $doctors=User::where('role',1)->get();
        $Patient=User::where('role',0)->get();
if(!isset($request['name']) ||!isset($request['description'])
       ||trim($request['name']) == "" || trim($request['description']) == "")

    return view('/admin/specializations',['error' => " Insert all the fields"],['doctors'=>$doctors],['Patient'=>$Patient]);
    $name=strtolower(trim($request['name']));
    $description=trim($request['description']);
    $is_exist= specialization::where('name',$name)->count();
    if($is_exist > 0)
    return view('/admin/specializations',['error' => "This  specialization is already exists"],['doctors'=>$doctors],['Patient'=>$Patient]);
    specialization::create([
        'name' => $name,
        'details' =>$description,
    ]);
    return view('/admin/specializations',['success' => "This  specialization add sucessfully"],['doctors'=>$doctors],['Patient'=>$Patient]);
        }

        public function add_Doctor(Request $request){
            $doctors=User::where('role',1)->get();
            $Patient=User::where('role',0)->get();
            if(!isset($request['name']) ||!isset($request['email'])
            ||trim($request['name']) == "" || trim($request['email']) == ""
            ||!isset($request['specialization']) || trim($request['specialization']) == ""
            ||!isset($request['password']) || ($request['password']) == "" )

                return view('/admin/doctor',['error' => " Insert all the fields"],['doctors'=>$doctors],['Patient'=>$Patient]);
            $email=strtolower(trim($request['email']));
            $name=strtolower(trim($request['name']));
            $specialization=$request['specialization'];
            $user=User::where('email',$email)->count();
            if($user > 0)
                return view('/admin/doctor',['error' => " This user already exists"],['doctors'=>$doctors],['Patient'=>$Patient]);
            $is_exist= specialization::where('id',$specialization)->count();
            if($is_exist == 0)
                return view('/admin/doctor',['error' => "This  specialization is already exists"],['doctors'=>$doctors],['Patient'=>$Patient]);
            $user=User::create ([
            'name' => $name,
            'email' =>$email,
            'password' => Hash::make($request['password']),
            'role' => 1,
            'duration'=>60
            ]);
            Doctor_specialization::create ([
            'user_id'=> $user->id,
            'specialization_id'=>$specialization,
            ]);

            return view('/admin/doctor',['success' => "This  Doctor add sucessfully"], ['doctors'=>$doctors],['Patient'=>$Patient]);
        }


    public function profileUpdate(Request $request){


        $request->validate([
            'name' =>'required|min:4|string|max:255',
            'email'=>'required|email|string|max:255',

        ]);
        User::where('id', Auth::user()->id)->update
       ([
            'name' =>$request['name'],
         'email'=> $request['email'],
         ]);
        return back()->with('message','Profile Updated');

    }

        }





