<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Date;
use App\Models\OffDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Working_Ranges;



class DoctorController extends Controller

{
    public function Available_Ranges_index(){

        $working__ranges= Working_Ranges::where("doctor_id",Auth::user()->id)->get();
        return view ('/doctor/Available_Ranges',['working__ranges'=> $working__ranges]);
      }
    public function Add_Working_Hours_index(){
        $working__ranges= Working_Ranges::where("doctor_id",Auth::user()->id)->get();
        return view ('/doctor/Add_Working_Hours',['working__ranges'=> $working__ranges]);
      }
    public function dashboard_index(){
        $working__ranges= Working_Ranges::where("doctor_id",Auth::user()->id)->get();
        return view ('doctor.home',['working__ranges'=> $working__ranges]);
      }
      public function add_range(Request  $request){
        $working__ranges= Working_Ranges::where("doctor_id",Auth::user()->id)->get();
        $start=$request['start'];
        $end=$request['end'];
        if($start >= $end){
            return view('/doctor/Add_Working_Hours',['error' => "Please enter a valid range"],['working__ranges'=> $working__ranges]);
        }

    $working__ranges = Working_Ranges::where("doctor_id",Auth::user()->id)->get();
      foreach($working__ranges as $range){
        if($end < $range->start_hour || $start> $range->end_hour) continue;
        return view('/doctor/Add_Working_Hours',['error' => "There is a conflict with range"],['working__ranges'=> $working__ranges]);
      }

     $User=Working_Ranges::create ([
        'doctor_id' => Auth::user()->id,
        'start_hour'=>$start,
        'end_hour'=> $end,
      ]);
      $working__ranges= Working_Ranges::where("doctor_id",Auth::user()->id)->get();
      return view('/doctor/Add_Working_Hours',['success' => "This range added sucessfully"],['working__ranges'=> $working__ranges]);
      }
      public function  update_user_time(Request $request){
        $working__ranges = Working_Ranges::where("doctor_id",Auth::user()->id)->get();
        if(isset($request['duration']) && is_numeric ($request['duration']) && $request['duration'] >0 && $request['duration']<60)
       { user::where ('id',Auth::user()->id)->update([
            'duration'=>$request['duration'],
       ]);
       return view('/doctor/Add_Working_Hours',['success' => "The time updated sucessfully"],['working__ranges'=> $working__ranges]);

      }
      return view('/doctor/Add_Working_Hours',['error' => "Error in updating"],['working__ranges'=> $working__ranges]);



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

    public function add_off_days(Request $request){
        $working__ranges= Working_Ranges::where("doctor_id",Auth::user()->id)->get();
        $date= date('Y-m-d G:i:s',strtotime($request['date']));
        $picked_dates= Date::where('doctor_id',Auth::user()->id)
        ->where('confirmed',1)
        ->where('date','>=',$date)
        ->where('date','<', date('Y-m-d G:i:s',strtotime($request['date'] .'+1day')))
        ->count();
        if($picked_dates > 0)
        return view('/doctor/Add_Working_Hours',['error' => "there are confirmed dates in this day"],['working__ranges'=> $working__ranges]);
        OffDay::create ([
       'user_id' => Auth::user()->id,
       'day' =>$date
        ]);
        return view('/doctor/Add_Working_Hours',['success' => "this day marked as off day sucessfully"],['working__ranges'=> $working__ranges]);

    }
}
