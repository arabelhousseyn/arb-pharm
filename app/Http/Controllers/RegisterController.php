<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use Auth,Hash;
use App\Models\{
    User,
    UserProfile,
    UserPayment,
    Admin
};
use Validator,Str,Notification;
use App\Notifications\UserRegistration;
use App\Traits\uploads;

class RegisterController extends Controller
{
    use uploads;
    public function register(RegisterUserRequest $request)
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
            $usr = User::whereId($user->id)->first();
            $data = [
                'name' => 'Nouveaux utilisateur',
                'body' => 'Dis salut à lui',
                'thanks' => 'Merci',
                'offerText' => 'Vérifiez l\'utilisateur',
                'offerUrl' => url('/users'),
                'data' => $usr,
            ];
            $admins = Admin::all();
            foreach ($admins as $admin) {
                Notification::send($admin,new UserRegistration($data));
            }
            $usr['success'] = true;
            return response($usr,200);

        }

    }
}
