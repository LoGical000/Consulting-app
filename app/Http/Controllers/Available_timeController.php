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
            'data'=> $times
        ], 200);
        
    }

}
