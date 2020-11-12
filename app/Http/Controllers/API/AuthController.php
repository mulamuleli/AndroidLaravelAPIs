<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $creds= $request->only([
            'email','password'
        ]);
         if(!$token=auth()->attempt($creds)){
             return response()->json(
                 ['success'=>false,
                 'message'=> 'not found']
             );
         }
        return response()->json(
            ['success'=>true,
            'token'=>$token,
            'User'=>Auth::User()

            ]
        );
    }
}
