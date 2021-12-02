<?php

namespace App\Http\Controllers;

use App\Models\{User, UserPayment, UserProfile};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Str;
use App\Traits\uploads;
use App\Http\Requests\insertUserRequest;
class UserController extends Controller
{
    use uploads;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::orderByDesc('created_at')->get();
        $data = $data->map(function($value){
            return $value->only('id','phone','email','date_creation','activation','is_active');
        });
        return response($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(insertUserRequest $request)
    {
        if($request->validated())
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $delete = $user->deleteOrFail();
        response($delete,200);
    }

    public function activateUser(Request $request,User $user)
    {
        $rules = [
            'days' => 'required'
        ];
        $validation = $request->validate($rules);
        if($validation)
        {
            $user->update([
                'activated_at' => Carbon::now(),
                'days' => strval($request->days)
            ]);
            return response(['success' => true],200);
        }

        $response = [
            'errors' => [
                'days' => [
                    'Champ requis'
                ]
            ]
        ];
        return response($response,422);
    }

    public function deactivateUser(User $user)
    {
        $user->update([
            'activated_at' => null,
            'days' => null
        ]);
        return response(['success' => true],200);
    }
}
