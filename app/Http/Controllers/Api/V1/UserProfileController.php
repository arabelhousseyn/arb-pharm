<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfilePicRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\updateProfileRequest;
use App\Http\Requests\UpdateProfileUserRequest;
use App\Traits\uploads;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, UserProfile};
use Illuminate\Support\Facades\Auth;
use Validator;
use function response;

class UserProfileController extends Controller
{
    use uploads;
    public function storeProfilePic(StoreProfilePicRequest $request)
    {
        if($request->validated())
        {
            $path = $this->upload($request->profile_pic,'profiles','.jpg');
            $path = env('PATH_STORAGE') .'profiles/'. $path;
            UserProfile::where('user_id',Auth::id())->update(['profile_pic' => $path]);

            return response()->noContent();
        }
    }

    public function favoritesProducts()
    {
        $data = User::with('favorites.product','favorites.product.images:path,product_id')->whereId(Auth::id())->first();
        $products = $data->favorites;
        $subset = $products->map(function($prod){
            return $prod->product->only(['id','description','rating','image','published_by']);
        });
        return response($subset,200);
    }

    public function profile($user_id)
    {
        if($user_id == 0)
        {
            $data = User::with('profile')->withCount('products','requests')->where('id',Auth::id())->first();
            $subset =  $data->only(['id','phone','profile_name','products_count','requests_count']);
            return response($subset,200);
        }else{
            $data = User::with('profile')->withCount('products','requests')->where('id',$user_id)->first();
            $subset =  $data->only(['id','phone','profile_name','products_count','requests_count']);
            return response($subset,200);
        }
    }

    public function ProfileDetails()
    {
        $data = User::with('profile')->find(Auth::id());
        return response(['data' => $data],200);
    }

    public function getMyProducts($user_id)
    {
        if($user_id == 0)
        {
           $data = User::with('products')->where('id',Auth::id())->first();
           $subset = $data->products->map(function($prod){
               return $prod->only(['id','description','rating','image','published_by']);
           });
           return response($subset,200);
        }else{
            $data = User::with('products')->where('id',$user_id)->first();
            $subset = $data->products->map(function($prod){
                return $prod->only(['id','description','rating','image','published_by']);
            });
            return response($subset,200);
        }
    }

    public function getMyRequest($user_id)
    {
        if($user_id == 0)
        {
            $final = [];
            $data = User::with('requests.offers')->where('id',Auth::id())->first();
            $subset = $data->requests->map(function($req){
                return $req->only(['id','product_name','amount','image','publishedBy','offers']);
            });

            foreach ($subset as $item) {
                $count_offer = count($item['offers']);
                $data = [
                    'id' => $item['id'],
                    'product_name' => $item['product_name'],
                    'amount' => $item['amount'],
                    'image' => $item['image'],
                    'publishedBy' => $item['publishedBy'],
                    'count_offers' => $count_offer
                ];
                $final[] = $data;
            }
            return response($final,200);
        }else{
            $final = [];
            $data = User::with('requests.offers')->where('id',$user_id)->first();
            $subset = $data->requests->map(function($req){
                return $req->only(['id','product_name','amount','image','publishedBy','offers']);
            });

            foreach ($subset as $item) {
                $count_offer = count($item['offers']);
                $data = [
                    'id' => $item['id'],
                    'product_name' => $item['product_name'],
                    'amount' => $item['amount'],
                    'image' => $item['image'],
                    'publishedBy' => $item['publishedBy'],
                    'count_offers' => $count_offer
                ];
                $final[] = $data;
            }
            return response($final,200);
        }
    }

    public function updateProfile(updateProfileRequest $request)
    {
        if($request->validated())
        {
            Auth::user()->update($request->only('phone','email'));
            $user = User::find(Auth::id());
            $user->profile()->update($request->except('phone','email'));
            return response()->noContent();
        }
    }

    public function changePassword(UpdatePasswordRequest $request)
    {
        if($request->validated())
        {
            if(Hash::check($request->old_password,Auth::user()->password))
            {
                $hashed_new_password = Hash::make($request->new_password_confirmation);

                Auth::user()->update([
                    'password' => $hashed_new_password
                ]);
                return response()->noContent();
            }else{
                $errors = [
                    'errors' => [
                        'password' => [
                            __('messages.old_password')
                        ]
                    ]
                ];
                return response($errors,422);
            }

        }
    }


}
