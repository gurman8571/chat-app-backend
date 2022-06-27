<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

use Validator;

class AuthController extends Controller
{
    public function Register(request $req)
    {
            $validator = Validator::make( $req->all(),[
            'name' => 'required|string',
            'email'    => 'unique:users|required|email',
            'password' => 'required|min:8',
            ]);

if($validator->fails()){
return response()->json([
    'validation_errors'=>$validator->messages(),

]);

}
else{
            $user=User::create([
              'name'=>$req->name,
              'email'=>$req->email,
              'password'=>Hash::make($req->password),

            ]);
            $token=$user->createToken($user->email.'_Token')->plainTextToken;
           return response()->json([

            'status'=>201,
            'token'=>$token,
            'username'=>$user->name,
            'message'=>' successfully registered',
           ]);
        }
    }
    public function login(request $req)
    {
        $validator = Validator::make( $req->all(), [

             'email'    => 'required|email',
             'password' => 'required|string',
            ]);

          //check email
          $user=User::where('email',$req->email)->first();
          //check password

          if($validator->fails()){

            return response()->json([
                'validation_errors'=>$validator->messages(),

            ]);
          }
          if (!$user || !Hash::check($req->password,$user->password)) {
            return response()->json([

                'status'=>401,


                'message'=>' username or password is incorrect',
               ]);
          }

            $token=$user->createToken('token')->plainTextToken;
            return response()->json([

                'status'=>200,
                'token'=>$token,
                'username'=>$user->name,
                'message'=>' successfully Logged in ',
               ]);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([

            'status'=>200,

            'message'=>' successfully Logged out ',
           ]);
    }

    public function Forgotpassword(request $req)
    {
        $validator = Validator::make( $req->all(), [
            'email'    => 'required|email'
                ]);

                if($validator->fails()){
                    return response()->json([
                        'validation_errors'=>$validator->messages(),

                    ]);
                }
                    else{
                                Password::sendResetLink($req->email);
                                return response()->json([

                                    'status'=>200,

                                    'message'=>' mail send successfully',
                                   ]);
                    }


    }

}
