<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Expert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class AppointmentController extends Controller
{
   
    public function index()
    {
        //
    }

    public function makeAppointment(Request $request)
    {
        $rules = [
            'client_id' => ['required', 'integer'],
            'expert_id' => ['required', 'integer'],
            'day' => ['required', 'integer'],       
        ];
        $validator = Validator::make($request->all(), $rules);



        if($validator->fails()) {
            return response()->json([
                'success' => '0',
                'message' => $validator->errors()->all()
            ], 422);
        }

        $query = DB::table('experts')
                  ->where('user_id','=',$request->expert_id)
                  ->first();
        $expert_price=$query->price;          

        
        $client = DB::table('users')
                  ->where('id','=',$request->client_id)
                  ->first();
        $client_bank=$client->bank;

        $expert = DB::table('users')
                  ->where('id','=',$request->expert_id)
                  ->first();
        $expert_bank=$expert->bank;




        User::query()->find($request->client_id)->update([
            'bank'=>$client_bank-$expert_price
            ]);

         User::query()->find($request->expert_id)->update([
            'bank'=>$expert_bank+$expert_price
            ]);    
      

        $appointment = Appointment::create([
        'client_id'=>$request->client_id,
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
            'date'=> $times
        ], 200);
        
    }
}
