<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfilePicRequest;
use App\Models\{User, UserActivityCode};
use Illuminate\Support\Facades\Auth;
use Validator;
use function response;

class UserProfileController extends Controller
{

    public function storeProfilePic(StoreProfilePicRequest $request)
    {
        if($request->validated())
        {
            $path = $this->upload($request->profile_pic,'profiles','.jpg');
            $path = env('PATH_STORAGE') .'profiles/'. $path;
            Auth::user()->update(['profile_pic' => $path]);

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
}
