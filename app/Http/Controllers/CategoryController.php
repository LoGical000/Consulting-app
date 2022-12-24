<?php

namespace App\Http\Controllers;

use App\Models\Category;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

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

}
