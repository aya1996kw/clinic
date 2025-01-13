<?php

namespace App\Http\Controllers;
use  App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Working_Ranges;
use App\Models\Date;
use App\Models\OffDay;
use App\Models\Rating;

class ClientController extends Controller
{
    public function dashboard_index(){
        $doctors=User::where('role',1)->get();
        return view ('client.home',['doctors'=>$doctors]);
      }

    // public function ajax_index(){
    //    $ret=[
        // 'de'=> User::where('role',1)->get()
    //    ];
        // return json_encode($ret);
    // }

    public function add_date_index(){
        $doctors= User::where('role',1)->get();
        return view ('/client/add',['doctors'=> $doctors]);
      }
    public function pick_date(Request $request){
        $doctors=User::where('role',1)->get();
      $doctor=user::where('email',$request['email'])->first();
      if($doctor==Null)
      return view('/client/add',['error' => "This doctor is not exists in our system"],['doctors'=> $doctors]);
      $hour=date('G',strtotime($request['date']));
      $minute =date('i',strtotime($request['date']));
      $date=date('Y-m-d',strtotime($request['date']));
$off_day=OffDay::where('user_id',$doctor->id)->where('day',$date)->count();
if($off_day > 0)
return view('/client/add',['error' => "This doctor has off day in the picked date"],['doctors'=> $doctors]);



      $full_date=date('Y-m-d G:i:s',strtotime($request['date']));
      $working__ranges= Working_Ranges::where("doctor_id",$doctor->id)->get();
      $found_time=false;


      foreach($working__ranges as $range)
      {
      if((($hour * 60)+ $minute )>= ($range->start_hour * 60) && (($hour * 60)+$minute) < ($range->end_hour * 60) - ($doctor->duration)){

        $found_time=true;
        break;
      }
    }

      if($found_time == false)
      return view('/client/add',['error' => "This doctor doesn't in this time "],['doctors'=>$doctors]);
      $picked_dates= Date ::where('doctor_id',$doctor->id)
                        ->where('confirmed',1)
                        ->where('date','<=' ,$full_date)
                        ->where('date','>',date('Y-m-d G:i:s',strtotime($request['date'].'-'.$doctor->duration .'minutes')))
                        ->count();
           if($picked_dates > 0)
           return view('/client/add',['error' => "This time isn't available for this doctor "],['doctors'=>$doctors]);

           $picked_dates= Date ::where('doctor_id',$doctor->id)
                        ->where('confirmed',1)
                        ->where('date','>=',$full_date)
                        ->where('date','<', date('Y-m-d G:i:s',strtotime($request['date'].'-'.$doctor->duration .'minutes')))
                        ->count();
           if($picked_dates>0)
           return view('/client/add',['error' => "This time isn't available for this doctor "],['doctors'=>$doctors]);

          Date::create ([
            'user_id' => Auth::user()->id,
            'doctor_id'=>$doctor->id,
            'date'=> $full_date,
            'confirmed'=> 1,//pleas change this to 0 when you add the payment integration
          ]);

          return view('/client/add',['success'=> "This time picked successfully"],['doctors'=>$doctors]);

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

    public function rating (Request $request){
    $doctors=User::where('role',1)->get();
    if(!isset($request['product_rating']) ||!isset($request['description'])
    ||($request['product_rating']) == "" || trim($request['description']) == "")
    return view('/client/add',['error' => " Insert all the fields"],['doctors'=>$doctors]);
    $doctor=user::where('email',$request['email'])->first();
    if($doctor==Null)
    return view('/client/add',['error' => "This doctor is not exists in our system"],['doctors'=> $doctors]);

    Rating::create ([
        'user_id' => Auth::user()->id,
        'doctor_id'=>$doctor->id,
        'rate' =>$request['product_rating'],
        'notes' =>$request['description'],
      ]);

      return view('/client/add',['success'=> "This Rating is successfully"],['doctors'=>$doctors]);
    }


}
