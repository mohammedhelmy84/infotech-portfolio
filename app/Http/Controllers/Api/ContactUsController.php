<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Validator;


class ContactUsController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'mobile' => ['required','regex:/^[0-9]{11}$/'],
            'address' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'title' => 'required|in:option1,option2,option3,option4',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'حقول مطلوبة',
                'errors' => $validator->errors()
            ], 422);
        }

        $contactus = ContactUs::create([
            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname,
            'mobile'=>$request->mobile,
            'address'=>$request->address,
            'email'=>$request->email,
            'title'=>$request->title,
            'message'=>$request->message,
   
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'تم الإرسال بنجاح'
        ], 200);
    }
}
