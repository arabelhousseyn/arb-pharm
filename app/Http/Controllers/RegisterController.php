<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth,Hash;
use App\Models\{
    User,
    UserProfile,
    UserPayment,
    Admin
};
use Validator;
use Str;
use App\Traits\uploads;
class RegisterController extends Controller
{
    use uploads;
    public function register(Request $request)
    {
        $rules = [
            'phone' => 'required|digits:10|unique:users',
            'email' => 'required|unique:users|email:rfc,dns,filter',
            'password' => 'required',
            'commercial_name' => 'required',
            'num_rc' => 'required',
            'nif' => 'required',
            'nis' => 'required',
            'num_ar' => 'required',
            'pro_card' => 'required',
            'adress' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response(['success' => false],200);
        }

        if($validator->validated())
        {
            $user = User::create([
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $token = $user->createToken('my-app-token')->plainTextToken;

            User::whereId($user->id)->update([
                'token' => $token
            ]);

            UserProfile::insert([
                'user_id' => $user->id,
                'commercial_name' => $request->commercial_name,
                'num_rc' => $request->num_rc,
                'nif' => $request->nif,
                'nis' => $request->nis,
                'num_ar' => $request->num_ar,
                'pro_card' => $request->pro_card,
                'adress' => $request->adress
            ]);

            if($request->has_payment)
            {
                $payment = (Str::length($request->payment) != 0) ? $this->upload($request->payment,'payment','.jpg') : null;
                $rc = (Str::length($request->rc) != 0) ? $this->upload($request->rc,'rc','.jpg') : null;
                $activity_code = (Str::length($request->activity_code) != 0) ? $this->upload($request->activity_code,'activity_code','.jpg') : null;
                $pro_card = (Str::length($request->card_pro) != 0) ? $this->upload($request->card_pro,'pro_card','.jpg') : null;
                $paths = [
                    'RECEIPT' => ($payment == null) ? null : env('PATH_STORAGE') .'payment/'. $payment,
                    'RC' => ($rc == null) ? null : env('PATH_STORAGE') .'rc/'. $rc,
                    'ACTIVITY_CODE' => ($activity_code == null) ? null : env('PATH_STORAGE') .'activity_code/'. $activity_code,
                    'PRO_CARD' => ($pro_card == null) ? null :env('PATH_STORAGE') .'pro_card/'. $pro_card
                ];

                foreach ($paths as $key => $path)
                {
                    if($path != null)
                    {
                        UserPayment::insert([
                            'user_id' => $user->id,
                            'type' => $key,
                            'path' => $path
                        ]);
                    }
                }

            }
            $usr = User::find($user)->first();
            $usr['success'] = true;
            return response($usr,200);

        }

    }

    public function createAdmin(Request $request)
    {
        $rules = [
            'phone' => 'required|digits:10|unique:admins',
            'email' => 'required|unique:admins|email:rfc,dns,filter',
            'password' => 'required',
            'fname' => 'required',
            'lname' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response(['success' => false],200);
        }

        if($validator->validated())
        {
            $username = $request->fname .'_'.$request->lname . uniqid();
            $admin = Admin::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'phone' => $request->phone,
                'username' => $username,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $token = $admin->createToken('my-app-token')->plainTextToken;

            Admin::whereId($admin->id)->update([
                'token' => $token
            ]);
            $usr = Admin::find($admin)->first();
            $usr['success'] = true;
            return response($usr,200);
        }
    }
}
