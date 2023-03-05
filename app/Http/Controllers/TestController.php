<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\MyTestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function mail()
    {


        $mailData = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp.'
        ];
         
        Mail::to('mkmmohamedmostafa90908080@gmail.com
        ')->send(new MyTestMail($mailData));
           
        dd("Email is sent successfully.");
    }
    public function api(){
        $user=User::all();
      
        return $user;
    }
 
    
}
