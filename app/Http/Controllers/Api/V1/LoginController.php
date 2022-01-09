<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Validator;
use function response;

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
             return response(['success' => false],403);
         }

         if($valiadator->validated())
         {
             if($request->has_phone)
             {
                 $rules = [
                     'phone' => 'required|digits:10',
                     'password' => 'required'
                 ];
                 $credinalts = $request->validate($rules);


                 return (Auth::attempt($credinalts)) ? response(Auth::user(),200) : response(['success' => false],403);
             }else{
                 $rules = [
                     'email' => 'required|email:rfc,dns,filter',
                     'password' => 'required'
                 ];
                 $credinalts = $request->validate($rules);


                 return (Auth::attempt($credinalts)) ? response(Auth::user(),200) : response(['success' => false],403);
             }

         }
    }
}
