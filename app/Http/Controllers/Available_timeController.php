<?php

namespace App\Http\Controllers;

use App\Models\Available_time;
use Illuminate\Http\Request;

class Available_timeController extends Controller
{
    
    public function getAvailableTimes(Request $request)
    {
        $timesQuery = Available_time::query();
        $timesQuery->where('id',$request->user_id);
        $times = $timesQuery->get();

        return response()->json([
            'success' => '1',
            'date'=> $times
        ], 200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Available_time  $available_time
     * @return \Illuminate\Http\Response
     */
    public function show(Available_time $available_time)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Available_time  $available_time
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Available_time $available_time)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Available_time  $available_time
     * @return \Illuminate\Http\Response
     */
    public function destroy(Available_time $available_time)
    {
        //
    }
}
