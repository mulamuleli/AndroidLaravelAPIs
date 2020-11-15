<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
// use Exception;
use Illuminate\Support\Facades\Hash;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;


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
                 'message'=> 'invalid credentials']
             );
         }
        return response()->json(
            ['success'=>true,
            'token'=>$token,
            'User'=>Auth::User()

            ]
        );
    }
    public function Register(Request $request)
    {
        $EncryptedPassword=Hash::make($request->password);

        $user= new User;
        try{
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=$EncryptedPassword;
            $user->save();

            return $this->login($request);
        }
        catch(Exception $error)
        {
            return response()->json([
                'success' => false,
                'message'=> ''.$error
            ]);
        }
    }
    public function Logout(Request $request)
    {
        try
        {
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json(
                [
                    'success'=>true,
                    'message'=>'Logged Out Successfully'
                    
                ]
            );
        }   
        catch(Exception $error)
        {
            return response()->json(
                [
                    'success'=>false,
                    'message'=>'something went wrong'
                    
                ]
            ); 
        }
    }
}
