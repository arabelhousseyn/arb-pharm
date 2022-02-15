<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ResetPasswordRequest $request)
    {
        if($request->validated())
        {
            User::where('code_verification',$request->code_verification)->update([
                'password' => Hash::make($request->new_password),
                'code_verification' => null
            ]);
            return response(['success' => true],200);
        }
    }
}
