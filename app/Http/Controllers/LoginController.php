<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{

    public function auth(Request $request)
    {
        $rules = [
            'phone' => 'required|digits:10',
            'password' => 'required'
        ];
        $credinalts = $request->validate($rules);
        return (Auth::attempt($credinalts)) ? response(Auth::user(),200) : response(['success' => false],200);
    }
}
