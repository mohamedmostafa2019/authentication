<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\RegisterRequest;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class RegisterController extends Controller
{
    use GeneralTrait;
 public function register(Request $request){
  $rules =array (
    'name' => 'required',
    'email' => 'email|required|unique:users',
    'password' => 'required|min:6|',
    'confirmPassword'=>'required|same:password',
    "phone" => 'required|numeric|digits:11',
  );
    $validator = validator::make($request->all(),$rules);
   
    if( $validator->fails()){
        return response()->json($validator->errors());
    }
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make( $request->password),
        'confirmPassword'=> bcrypt(   $request->confirmPassword),
        'phone' => $request->phone,
    ]);
    $user->notify(new EmailVerificationNotification());
    $success['token']=$user->createToken(request()->userAgent())->plainTextToken;

    return response()->json([
        $success,
        'email' =>$user->email,
        'password' =>$user->password,
        'status' => true, 
        
        $user,
    ], 200);
}}




 // return response()->json([
        //     'status' => false,
        //     'message' => 'validation error',
        //     'errors' => $validateUser->errors()
        // ], 401);

// public function register(Request $request){
//     $request->validate([


//         'name'=>'required',
//         'email'=> 'required|unique:users,email',
//         'password'=>'required|min:6|confirmed',
//         'phone'=>'sometimes|unique:users,phone|digits:11',
//        ]) ;
//        $newUser =User::create([
//        'name'=> $request->name,
//        'email'=>$request->email,
//        'password'=>$request->password,
//        'confirmPassword'=> $request->confirmPassword,
//        'phone'=>$request->phone
    
    
//        ]);
//        return $newUser;
      
    
           
       
//     }