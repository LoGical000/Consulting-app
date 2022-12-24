<?php

namespace App\Http\Controllers;

use App\Models\Category;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    
    public function index()
    {
        
    }

  
    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required', 
        ]);

        $category = Category::create([
            'name'=>$request->name
        ]);

        if($category){

            return response()->json([
               'success'=>1,
               'massege'=>'category created'

            ],200
            
            );
        }
    }

    public function searchBycategory(Request $request)
    {


        $category = DB::table('categories')
              ->where('name','like','%'.$request->name.'%')
              ->first();

              

        if($category){
            return response()->json([
                'success' => '1',
                'date'=> $category
            ], 200);
        }
        
        return response()->json([
            'success' => '0',
            'massage' => "No result found"
        ], 404);
        
        


    }

}
