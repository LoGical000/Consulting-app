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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
