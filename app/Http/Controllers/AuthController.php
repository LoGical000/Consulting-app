<?php

namespace App\Http\Controllers;

use App\Models\Available_time;
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
            'password_confirmation' => ['required', 'string','same:password'],
            'is_expert'=>['required','integer','max:1']
    
        ];

        $validator = Validator::make($request->only('name','email','password','password_confirmation','is_expert'), $rules);
        


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

       return $this->success([
        'user'=>$user,
        'token'=>$user->createToken('API Token of'.$user->name)->plainTextToken

       ]);
    }
    

    public function ExpertRegister(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string','min:8'],
            'password_confirmation' => ['required', 'string','same:password'],
            'is_expert'=>['required','integer','max:1'],
            'price'=> ['required'],
            //'image_url'=>['nullable'],
            'phone'=>['required', 'string','min:9', 'max:10'],
            'address'=>['required', 'string'],
            'details'=>['required'],
            'category_id'=>['required'],
            'saturday'=>['required','integer','min:0','max:1'],
            'sunday'=>['required','integer','min:0','max:1'],
            'monday'=>['required','integer','min:0','max:1'],
            'tuesday'=>['required','integer','min:0','max:1'],
            'wednesday'=>['required','integer','min:0','max:1'],
            'thursday'=>['required','integer','min:0','max:1'],
            'friday'=>['required','integer','min:0','max:1'],        
        ];
        $validator = Validator::make($request->all(), $rules);



        if($validator->fails()) {
            return response()->json([
                'success' => '0',
                'message' => $validator->errors()->all()
            ], 422);
        }

        $image_name='default.jpg';
        $path = 'public/images';

        if ($request->hasFile('image')) { 
            $image_name = time(). '-' . $request->name . '.' . $request->image->extension();
            $request->image->move($path,$image_name);
        }
        



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_expert'=>$request->is_expert,
        
        ]);

        $expert = Expert::create([
                    'user_id'=>$user->id,
                    'price' => $request->price,
                    'image_url' => $image_name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'details' => $request->details,
                    'category_id' => $request->category_id,
                ]);

        $available_times = Available_time::create([
            'user_id'=>$user->id,
            'saturday'=>$request->saturday,
            'sunday'=>$request->sunday,
            'monday'=>$request->monday,
            'tuesday'=>$request->tuesday,
            'wednesday'=>$request->wednesday,
            'thursday'=>$request->thursday,
            'friday'=>$request->friday,
        ]
        );        


                return $this->success([
                    'user'=>$user,
                    'expert'=>$expert,
                    'available_times'=>$available_times,
                    'token'=>$user->createToken('API Token of'.$user->name)->plainTextToken
            
                   ]);
   

    }




    public function logout(){

        Auth::user()->currentAccessToken()->delete();
        return $this->success([
         'messages'=>'successfully logged out'

        ]);
    }
}
