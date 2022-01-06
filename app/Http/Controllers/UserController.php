<?php

namespace App\Http\Controllers;

use App\Models\{User, UserPayment, UserProfile,UserActivityCode,UserSubscribe};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Str,Hash;
use App\Traits\uploads;
use App\Http\Requests\{insertUserRequest,ChangePasswordUserRequest,UpdateUserRequest,UpdateProfileUserRequest};
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
            return $value->only('id','phone','email','date_creation','activation','is_active','type','activation_date','expired_at');
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

            UserActivityCode::insert([
                'user_id' => $user->id,
                'code' => $request->activity_code
            ]);
            $images = explode(';',$request->images);
            foreach ($images as $image)
            {
                $path = $this->upload($image,'payment','.jpg');
                $path = env('PATH_STORAGE') .'payment/'. $path;
                UserPayment::insert([
                    'user_id' => $user->id,
                    'path' => $path
                ]);
            }
            $usr = User::find($user->id)->first();
            $usr['success'] = true;
            return response(['success' => true],201);

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
        return response($user,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if($request->validated())
        {
            $user->update([
                'email' => $request->email,
                'phone' => $request->phone
            ]);
            return response(['success' => true],200);
        }
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
            'date' => 'required',
            'type' => 'required'
        ];
        $validation = $request->validate($rules);
        if($validation)
        {
            $user->update([
                'activated_at' => Carbon::now(),
                'expired_at' => $request->date,
                'type' => strval($request->type)
            ]);

            UserSubscribe::insert([
                'user_id' => $user->id,
                'activated_at' => Carbon::now(),
                'expired_at' => $request->date,
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
            'days' => null,
            'type' => null,
        ]);
        return response(['success' => true],200);
    }

    public function changePassword(ChangePasswordUserRequest $request,User $user)
    {
        if($request->validated())
        {
            $checkPassword = Hash::check($request->old_password,$user->password);
            if($checkPassword)
            {
                if($request->new_password == $request->re_new_password)
                {
                    $user->update(['password' => Hash::make($request->re_new_password)]);
                    return response(['success' => true],200);
                }

                $response = [
                    'errors' => [
                        'password' => [
                            'Le mot de passe ne correspond pas'
                        ]
                    ]
                ];
                return response($response,422);
            }
            $response = [
                'errors' => [
                    'password' => [
                        'Ancien mot de passe erroné'
                    ]
                ]
            ];
            return response($response,422);
        }
    }

    public function updateProfileUser(UpdateProfileUserRequest $request,User $user)
    {
        if($request->validated())
        {
            UserProfile::whereUserId($user->id)->update([
                'commercial_name' => $request->commercial_name,
                'num_rc' => $request->num_rc,
                'nif' => $request->nif,
                'nis' => $request->nis,
                'num_ar' => $request->num_ar,
                'pro_card' => $request->pro_card,
                'adress' => $request->adress
            ]);
            UserActivityCode::whereUserId($user->id)->update([
                'code' => $request->activity_code
            ]);
            return response(['success' => true],200);
        }
    }

    public function profileInfo(User $user)
    {
        $data = User::with('payments')->whereId($user->id)->first();
        return response($data->only('profile_name','payments','get_profile','code'),200);
    }

    public function subscribeHistory(User $user)
    {
        $history = User::with('subscribeHistory')->whereId($user->id)->first();
        return response($history->subscribeHistory,200);
    }

    public function notifications($user_id)
    {
        $data = User::with('notifications')->find($user_id);
        return response($data->notifications,200);
    }
}
