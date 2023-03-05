<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\MyTestMail;
use App\Notifications\LoginNotification;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
  

 
  public function LoginForm(Request $request){

    $rules =array (
    
      'email' => 'email|required|unique:users',
      'password' => 'required|min:6|',
   
    );



    if(auth()->attempt(  ['email'=>$request->email,'password'=>$request->password])){
        
      $user =Auth::user();
      $user->tokens()->delete();
      $success['token']=$user->createToken(request()->userAgent())->plainTextToken;
           $success['email'] =$user->email;
            $success['success']=true;
            $user->notify(new LoginNotification());
            return response()->json([$success,200]);
            
    }else{
    
      $validator = validator::make($request->all(),$rules);
    if($validator->fails()){
      return response()->json($validator->errors());
   }

    }

  
  if (!Auth::attempt(['email' => $request->email,'password' =>  $request->password,])) {
  
    return response()->json([  'message'=> 'email  or password is not found',404]);

  
  }
}

}


  


// if (Auth::attempt(['email' => $request->email,'password' =>  $request->password,])) {
//     $user = Auth::user();
//     $success['token']=$user->createToken(request()->userAgent())->plainTextToken;
//     $success['email'] =$user->email;
//     $success['success']=true;
    
//     return response()->json([$success,200]);
  
//   }
//   else{
//   return response()->json(['error'=>'unauthorized',401]);
//   }
//   }


// if(auth()->attempt(['email' => $request->email,'password' =>  $request->password,])) {
//     $user = Auth::user();
//     $user->tokens()->delete();

//     $success['token']=$user->createToken(request()->userAgent())->plainTextToken;
//     $success['email'] =$user->email;
//     $success['success']=true;
//     return response()->json([$success,200]);
   
// }else{
//     return response()->json(['error'=>'unauthorized',401]);
//     //   
//   }}}
