<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Unique;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request){

        $rules = [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];


        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json([
                'success' => '0',
                'message' => $validator->errors()->all()
            ], 422);
        }

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->error('','Credentials do not match',401);
        }
            


        $user = User::where('email', $request->email)->first();


        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('API Token of'.$user->name)->plainTextToken
        ]
            
        );
    }

    public function register(Request $request){

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string','min:8'],
            'is_expert'=>['required','integer','max:1']
    
        ];

        $validator = Validator::make(request()->only('name','email','password','is_expert'), $rules);
        


        if($validator->fails()) {
            return response()->json([
                'success' => '0',
                'message' => $validator->errors()->all()
            ], 422);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_expert'=>$request->is_expert,
        
        ]);


        $is_expert=$request->is_expert;
        $test=$request->id;

         $input['price'] = $request->price;
         $input['image_url'] = $request->image_url;
         $input['phone'] = $request->phone;
         $input['address'] = $request->address;
         $input['details'] = $request->details;
         $input['category_id'] = $request->category_id;

         $expert_rules = [
            'price'=> ['required', 'double',],
            'image_url'=>['nullable'],
            'phone'=>['required', 'string','min:9', 'max:10'],
            'address'=>['required', 'string'],
            'details'=>['required',],
            'category_id'=>['required',]
            
        ];

            // if($is_expert==1){
            // //     $request->validate([
            // //         'price'=> ['required', 'double',],
            // // 'image_url'=>['text'],
            // // 'phone'=>['required', 'string','min:9', 'max:10'],
            // // 'address'=>['required', 'string'],
            // // 'details'=>['required', 'text'],
            // // 'category_id'=>['required',]
            // //     ]);

            //    // $validator2 = Validator::make(request()->only('price','image_url','phone','address','details','category_id'), $expert_rules);

            //     // if($validator2->fails()) {
            //     //     return response()->json([
            //     //         'success' => '0',
            //     //         'message' => $validator->errors()->all()
            //     //     ], 422);
            //     // }

            //     $expert = Expert::create([
            //         'user_id'=>$request->id,
            //         'price' => $request->price,
            //         'image_url' => $request->image_url,
            //         'phone' => $request->phone,
            //         'address' => $request->address,
            //         'details' => $request->details,
            //         'category_id' => $request->category_id,


            //     ]);

            //     return $this->success([
            //         'expert'=>$expert,
            //         'token'=>$expert->createToken('API Token of'.$expert->name)->plainTextToken
            
            //        ]);


            // }

       return $this->success([
        'user'=>$user,
        'token'=>$user->createToken('API Token of'.$user->name)->plainTextToken

       ]);
    }
    

    public function ExpertRegister(Request $request){
        // $rules = [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255'],
        //     'password' => ['required', 'string','min:8'],
        //     'is_expert'=>['required','integer','max:1'],
        //     'price'=> ['required', 'double'],
        //     'image_url'=>['nullable'],
        //     'phone'=>['required', 'string','min:9', 'max:10'],
        //     'address'=>['required', 'string'],
        //     'details'=>['required'],
        //     'category_id'=>['required']
    
        // ];

        $validator = Validator::make(request()->all(), [
            'name'=>['required','string','max:255'],
            'email'=>['required','string','email','max:255'],
            'password'=>['required','string','min:8'],
            

        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => '0',
                'message' => $validator->errors()->all()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_expert'=>$request->is_expert,
        
        ]);

             $expert = Expert::create([
                    //'user_id'=>$request->id,
                    'price' => $request->price,
                    'image_url' => $request->image_url,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'details' => $request->details,
                    'category_id' => $request->category_id,
                ]);


                return $this->success([
                    'user'=>$user,
                    'expert'=>$expert,
                    'token'=>$user->createToken('API Token of'.$user->name)->plainTextToken
            
                   ]);
   

    }




    public function logout(){

        return response()->json('this is logout');
    }
}
