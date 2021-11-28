<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth,Hash;
use App\Models\{
    User,
    UserProfile,
    UserPayment
};
use Validator;
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
            'num_commercial' => 'required',
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
                'password' => Hash::make($request->password),
                'token' => null
            ]);
            $token = $user->createToken('my-app-token')->plainTextToken;

            User::whereId($user->id)->update([
                'token' => $token
            ]);

            UserProfile::insert([
                'user_id' => $user->id,
                'num_commercial' => $request->num_commercial,
                'num_rc' => $request->num_rc,
                'nif' => $request->nif,
                'nis' => $request->nis,
                'num_ar' => $request->num_ar,
                'pro_card' => $request->pro_card,
                'adress' => $request->adress
            ]);

            if($request->has_payment)
            {
                $payment = $this->ImageUpload($request->payment,'payment','.jpg');
                $rc = $this->ImageUpload($request->rc,'rc','.jpg');
                $activity_code = $this->ImageUpload($request->activity_code,'activity_code','.jpg');
                $pro_card = $this->ImageUpload($request->card_pro,'pro_card','.jpg');
                $paths = [
                    'RECEIPT' => $payment,
                    'RC' => $rc,
                    'ACTIVITY_CODE' => $activity_code,
                    'PRO_CARD' => $pro_card
                ];

                foreach ($paths as $key => $path)
                {
                    UserPayment::insert([
                        'user_id' => $user->id,
                        'type' => $key,
                        'path' => $path
                    ]);
                }

            }
            $usr = User::find($user)->first();
            $usr['success'] = true;
            return response($usr,200);

        }

    }
}
