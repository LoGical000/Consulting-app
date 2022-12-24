<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Models\User;
use Illuminate\Http\Request;

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

        $users_id=$expertQuery->get('user_id');
        

        // foreach($users_id as $id){
        //    $user_id[]=$id;
        // }
        // $userQuery = User::query();
        // $userQuery->where('id',$user_id[1]);
        // $users = $userQuery->get();


            return response()->json([
                'success' => '1',
                'message' => 'Indexed successfuly!',
                'data'=> $experts
            ], 200);
        

            

        
    }

    public function getuser(Request $request){
       
        $userQuery = User::query();
        $userQuery->where('id',$request->user_id);
        $user=$userQuery->get();

        return response()->json([
            'success' => '1',
            'date'=> $user
        ], 200);



    }

    public function getExpertDetails(Request $request)
    {
        $expertQuery = Expert::query();
        $expertQuery->where('id',$request->expert_id);
        $experts = $expertQuery->get();

        return response()->json([
            'success' => '1',
            'date'=> $experts
        ], 200);
        
    }

    public function getAllExperts()
    {
        $expertQuery = Expert::query();
        $experts = $expertQuery->get();

        return response()->json([
            'success' => '1',
            'date'=> $experts
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expert  $expert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expert $expert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expert  $expert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expert $expert)
    {
        //
    }
}
