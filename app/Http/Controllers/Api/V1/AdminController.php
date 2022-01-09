<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\{ChangeAdminRequest, createAdminRequest, UpdateAdminRequest};
use App\Models\Admin;
use Auth;
use Hash;
use function response;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Admin::orderByDesc('created_at')->where('id','<>',Auth::id())->get();
        return response($data,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createAdminRequest $request)
    {
        if($request->validated())
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
            return response(['success' => true],201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return response($admin->only('id','fname','lname','phone','email','username'),200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {

        if($request->validated())
        {
           $update = $admin->update([
               'fname' => $request->fname,
               'lname' => $request->lname,
               'phone' => $request->phone,
               'email' => $request->email,
               'username' => $request->username,
           ]);
           return response(['success' => true],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $delete = $admin->deleteOrFail();
        response($delete,200);
    }

    public function changePassword(ChangeAdminRequest $request,Admin $admin)
    {
        if($request->validated())
        {
            $checkPassword = Hash::check($request->old_password,$admin->password);
            if($checkPassword)
            {
                if($request->new_password == $request->re_new_password)
                {
                    $admin->update(['password' => Hash::make($request->re_new_password)]);
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

    public function notification()
    {
        $admin = Admin::whereId(Auth::id())->first();
        $notifications = $admin->notifications;
        return response(['notifications' => $notifications,'count' => count($notifications)],200);
    }

}
