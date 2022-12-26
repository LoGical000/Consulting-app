<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getexperts(Request $request)
    {

        $expertQuery = Expert::query();
        $expertQuery->where('category_id',$request->category_id);
        $experts = $expertQuery->get();

        $users_id=$experts->get('user_id');
        

        // foreach($users_id as $id){
        //    $user_id[]=$id;
        // }
        // $userQuery = User::query();
        // $userQuery->where('id',$user_id[1]);
        // $users = $userQuery->get();


            return response()->json([
                'success' => '1',
                'data'=> $experts
            ], 200);
        

            

        
    }

    public function getuser(Request $request){
       
        $userQuery = User::query();
        $userQuery->where('id',$request->user_id);
        $user=$userQuery->get();

        return response()->json([
            'success' => '1',
            'data'=> $user
        ], 200);


    }

    public function getusername(Request $request){
        $userQuery = User::query();
        $userQuery->where('id',$request->user_id);
        $user=$userQuery->get('name');

        return response()->json([
            'success' => '1',
            'data'=> $user
        ], 200);



    }

    public function getExpertDetails(Request $request)
    {

        $expert = DB::table('experts')
                ->where('id','=',$request->expert_id)
                ->first();
        $user_id = $expert->user_id;

        $user = DB::table('users')
              ->where('id','=',$user_id)
              ->first();

        $data['name']=$user->name;
        $data['id']=$expert->id;  
        $data['user_id']=$expert->user_id;   
        $data['image_url']=$expert->image_url; 
        $data['phone']=$expert->phone;    
        $data['address']=$expert->address; 
        $data['details']=$expert->details;
        $data['rating']=$expert->rating;
        $data['category_id']=$expert->category_id;


        return response()->json([
            'success' => '1',
            'data'=> $data
        ], 200);
        
    }

    public function getAllExperts()
    {
        $expertQuery = Expert::query();
        $experts = $expertQuery->get();

        // $users=DB::table('users')->where('is_expert','=',1);
        // $input[]=$users->name;

        return response()->json([
            'success' => '1',
            'data'=> $experts,
            // 'names'=>$input
        ], 200);

    }

    public function searchByname(Request $request ){

        $user = DB::table('users')
              ->where('name','like','%'.$request->name)
              ->where('is_expert','=',1)
              ->first();
        
        if(!$user){
            return response()->json([
                'success' => '0',
                'massage' => "No result found"
            ], 404);
        }

        $expert = DB::table('experts')
                ->where('user_id','=',$user->id)
                ->first();

                $data['name']=$user->name;
                $data['id']=$expert->id;  
                $data['user_id']=$expert->user_id;   
                $data['image_url']=$expert->image_url; 
                $data['phone']=$expert->phone;    
                $data['address']=$expert->address; 
                $data['details']=$expert->details;
                $data['rating']=$expert->rating;
                $data['category_id']=$expert->category_id;        

        
            return response()->json([
                'success' => '1',
                'data'=>$data
            ], 200);
        
    
        

    }
}
