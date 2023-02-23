<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AuthResource;
use Auth;


class AuthController extends Controller
{
    public function login(Request $request){

        $msg = '';
        $data = '';
        $res = true;

        if(auth()->attempt(array('email' => $request->email, 'password' => $request->password))){
            $user = Auth::user();
            $data = new AuthResource($user);
            $msg = "Login Success";
          }else{
            $res = false;
            $msg = "Invalid Username Or Password";
          }


          return response()->json($this->prepareResponse($data,$msg,$res));
    }

    public function index(){
        
        $user = auth()->user();

        return response()->json($user);

    }
}
