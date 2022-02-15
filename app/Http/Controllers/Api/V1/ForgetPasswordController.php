<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Mail\SendVerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ForgetPasswordRequest $request)
    {
        if($request->validated())
        {
            $code = uniqid();
                User::where('email',$request->email)->update([
                    'code_verification' => $code
                ]);

                Mail::to($request->email)->send(new SendVerificationCodeMail($code));
                return response(['success' => true],200);
        }
    }
}
