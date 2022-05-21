<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\{Admin, User, UserPayment, UserProfile};
use App\Notifications\UserRegistration;
use App\Traits\uploads;
use Auth;
use Hash;
use Notification;
use Str;
use Validator;
use function env;
use function response;
use function url;

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

            if($request->has('profile_pic'))
            {
                $path = $this->upload($request->profile_pic,'profiles','.jpg');
                $path = env('PATH_STORAGE') .'profiles/'. $path;
            }


            UserProfile::insert([
                'user_id' => $user->id,
                'profile_pic' => ($request->has('profile_pic')) ? $path : null,
                'social_name' => $request->social_name,
                'social_place' => (strlen($request->social_place) == 0) ? null : $request->social_place,
                'commercial_name' => $request->commercial_name,
                'num_rc' => $request->num_rc,
                'nif' => $request->nif,
                'nis' => (strlen($request->nis) == 0) ? null : $request->nis,
                'num_ar' => (strlen($request->num_ar) == 0) ? null : $request->num_ar,
                'activity_code' => $request->activity_code,
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
