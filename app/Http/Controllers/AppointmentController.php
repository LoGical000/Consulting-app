<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Expert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class AppointmentController extends Controller
{


    public function makeAppointment(Request $request)
    {
        
        $request->validate([
            'expert_id' => 'required|integer',
            'day' => 'required|integer|min:1|max:7',
        ]);

        $client_id=Auth::id();

        $query = DB::table('experts')
                  ->where('user_id','=',$request->expert_id)
                  ->first();
        $expert_price=$query->price;          

        

        $client = DB::table('users')
                  ->where('id','=',$client_id)
                  ->first();
        $client_bank=$client->bank;

        if($client_bank<$expert_price){
            return response()->json([
             'message'=>'You Dont have enough money'
            ]);
        }

        // if($request->day==1){
        //     $day = DB::table('available_times')
        //           ->where('id','=',$request->expert_id)
        //           ->first();
        // $appointment_day=$day->sunday;
        //  if($appointment_day==0){
        //     return response()->json([
        //         'message'=>'The expert is not available on this day , please try a different day'
        //     ]);
        //  }
        // }

        // if($request->day==2){
        //     $day = DB::table('available_times')
        //           ->where('id','=',$request->expert_id)
        //           ->first();
        // $appointment_day=$day->monday;
        //  if($appointment_day==0){
        //     return response()->json([
        //         'message'=>'The expert is not available on this day , please try a different day'
        //     ]);
        //  }
        // }

        // if($request->day==3){
        //     $day = DB::table('available_times')
        //           ->where('id','=',$request->expert_id)
        //           ->first();
        // $appointment_day=$day->tuesday;
        //  if($appointment_day==0){
        //     return response()->json([
        //         'message'=>'The expert is not available on this day , please try a different day'
        //     ]);
        //  }
        // }

        // if($request->day==4){
        //     $day = DB::table('available_times')
        //           ->where('id','=',$request->expert_id)
        //           ->first();
        // $appointment_day=$day->wednesday;
        //  if($appointment_day==0){
        //     return response()->json([
        //         'message'=>'The expert is not available on this day , please try a different day'
        //     ]);
        //  }
        // }

        // if($request->day==5){
        //     $day = DB::table('available_times')
        //           ->where('id','=',$request->expert_id)
        //           ->first();
        // $appointment_day=$day->thursday;
        //  if($appointment_day==0){
        //     return response()->json([
        //         'message'=>'The expert is not available on this day , please try a different day'
        //     ]);
        //  }
        // }

        // if($request->day==6){
        //     $day = DB::table('available_times')
        //           ->where('id','=',$request->expert_id)
        //           ->first();
        // $appointment_day=$day->friday;
        //  if($appointment_day==0){
        //     return response()->json([
        //         'message'=>'The expert is not available on this day , please try a different day'
        //     ]);
        //  }
        // }

        // if($request->day==7){
        //     $day = DB::table('available_times')
        //           ->where('id','=',$request->expert_id)
        //           ->first();
        // $appointment_day=$day->saturday;
        //  if($appointment_day==0){
        //     return response()->json([
        //         'message'=>'The expert is not available on this day , please try a different day'
        //     ]);
        //  }
        // }

        $expert = DB::table('users')
                  ->where('id','=',$request->expert_id)
                  ->first();
        $expert_bank=$expert->bank;



        User::query()->find($client_id)->update([
            'bank'=>$client_bank-$expert_price
            ]);

         User::query()->find($request->expert_id)->update([
            'bank'=>$expert_bank+$expert_price
            ]);    
      
        $appointment = Appointment::create([
            'client_id'=>$client_id,
            'expert_id'=>$request->expert_id,
            'day'=>$request->day
            ]);

        return response()->json([
            'success' => '1',
            'data'=> $appointment,
            'client bank' => $client_bank,
            'expert bank' => $expert_bank
        ], 200);

        

    }

    public function getAppointment(Request $request)
    {


         $request->validate([
         'expert_id'=> 'required'|'integer'   
    ]);


        

        $timesQuery = Appointment::query();
        $timesQuery->where('expert_id',$request->expert_id);
        $times = $timesQuery->get();

        return response()->json([
            'success' => '1',
            'data'=> $times
        ], 200);
        
    }
}
