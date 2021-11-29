<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
class LoginController extends Controller
{

    public function auth(Request $request)
    {
        $rules = [
            'has_phone' => 'required'
        ];
         $valiadator = Validator::make($request->only('has_phone'),$rules);
         if($valiadator->fails())
         {
             return response(['success' => false],200);
         }

         if($valiadator->validated())
         {
             if($request->has_phone == true)
             {
                 $rules = [
                     'phone' => 'required|digits:10',
                     'password' => 'required'
                 ];
                 $credinalts = $request->validate($rules);


                 return (Auth::attempt($credinalts)) ? response(Auth::user(),200) : response(['success' => false],200);
             }else{
                 $rules = [
                     'email' => 'required|email:rfc,dns,filter',
                     'password' => 'required'
                 ];
                 $credinalts = $request->validate($rules);


                 return (Auth::attempt($credinalts)) ? response(Auth::user(),200) : response(['success' => false],200);
             }

         }
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email:rfc,dns,filter',
            'password' => 'required'
        ];
        $credinalts = $request->validate($rules);


        return (Auth::guard('admin')->attempt($credinalts)) ? response(Auth::guard('admin')->user(),200) : response(['success' => false],200);
    }
}
