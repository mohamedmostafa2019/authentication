<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function UpdateProfile(Request  $request){
        $rules =array (
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:6|',
            'confirmPassword'=>'required|same:password',
            "phone" => 'required|numeric|digits:11',
          );
            $validator = validator::make($request->all(),$rules);
            // if( $validator->fails()){
            //     return response()->json($validator->errors());
            // }
            $user =User::all();
           
            $user->update(['name'=>$request->name]);
            $user->update(['email'=>$request->email]);
            $user->update(['password' =>Hash::make($request->password)  ]);
            $user->update(['confirmPassword' =>Hash::make($request->confirmPassword)  ]);
            $user->update(['phone'=>$request->phone]);
          
            $user =$user ->refresh();
            $success['user'] =$user;
            $success['success'] =true;
            return response()->json($success,200);
            
        // $validateData = $request->validated();
        // 
     
        

    }
}
// $user = User::where('email',$request->email)->first();
