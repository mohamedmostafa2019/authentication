<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Notifications\LoginNotification;
use App\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    private $otp;
    public function __construct(){
        $this->otp = new Otp;

    }
    public function PasswordReset(ResetPasswordRequest $request){
        $otp2 =$this->otp->validate($request->email,$request->otp);
        if(!$otp2->status ){
            return response()->json(['error'=>$otp2],401);

        }
        $user = User::where('email',$request->email)->first();
        $user->notify(new LoginNotification());
        $user->update(['password' =>Hash::make($request->password)  ]);
       $user->update(['confirmPassword' =>Hash::make($request->confirmPassword )]);
        $user->tokens()->delete();
        $success['success']=true;
        return response()->json([$success ,200,$user]);

    }
}
