<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;



class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|same:confirm_password|min:8',
            'confirm_password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'حدث خطأ',
                'errors' => $validator->errors()
            ],422);
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'role'=>1,
            'password'=>Hash::make($request->password),
            'remember_token'=>Str::random(40),
        ]);
        
        $subjec = "verify email";
        $body = "تحقق من البريد الإلكتروني للتفعيل";
        Mail::to($request->email,)->send(new SendMail($user,$subjec,$body));
        return response()->json([
            'message' => 'تحقق من البريد الإلكتروني لتفعيل حسابك',
            'data' => $user
        ],200);
    }


    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',

        ]);

        $user = User::where('email','=',$request->email)->first();

     
  
      
        if ($validator->fails()) {
            return response()->json([
                'message' => 'حدث خطأ',
                'errors' => $validator->errors()
            ],422);
        }

        $user = User::where('email',$request->email)->first();

        $userdata = array(
            'email' => $request->email,
            'password' => $request->password
          );

        if(Auth::attempt($userdata)){
            if($user->email_verified_at==null){
                return response()->json([
                    'message' => 'تحقق من تفعيل الايميل',
                ],422);}

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'message' => 'تم الدخول بنجاح',
                'token'=>$token,
                'data'=>$user
            ],200);
        }else{
            return response()->json([
                'message' => 'بيانات الدخول غير صحيحة',
            ],400);
        }
    }

    
    public function verify(string $token){
   
        $user = User::where('remember_token','=',$token)->first();

      if(!empty($user)){
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();
        return response()->json([
            'message' => 'تم تفعيل الحساب بنجاح',
            'token' =>$token
        ],200);
      }else{
        return response()->json([
            'message' => 'لايوجد',
        ],404);
      }
        
    }



}
