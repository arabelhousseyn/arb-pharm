<?php

namespace App\Http\Controllers;

use App\Models\{User, UserPayment, UserProfile,UserActivityCode};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Str,Hash;
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
            return $value->only('id','phone','email','date_creation','activation','is_active','type','activation_date');
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
            $usr = User::find($user)->first();
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
        return $user->with('profile');
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
            'days' => 'required',
            'type' => 'required'
        ];
        $validation = $request->validate($rules);
        if($validation)
        {
            $user->update([
                'activated_at' => Carbon::now(),
                'days' => strval($request->days),
                'type' => strval($request->type)
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
}
