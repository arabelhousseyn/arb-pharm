<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\{User, UserActivityCode};
use Auth;
use Validator;
use function response;

class UserProfileController extends Controller
{
    public function insertCode($code)
    {
        $code = UserActivityCode::create([
            'user_id' => Auth::id(),
            'code' => $code
        ]);
        if($code)
        {
            return response(['success' => true],200);
        }else{
            return response(['success' => false],403);
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
            $data = User::with('requests')->where('id',Auth::id())->first();
            $subset = $data->requests->map(function($req){
                return $req->only(['id','product_name','amount','image','publishedBy']);
            });
            return response($subset,200);
        }else{
            $data = User::with('requests')->where('id',$user_id)->first();
            $subset = $data->requests->map(function($req){
                return $req->only(['id','product_name','amount','image','publishedBy']);
            });
            return response($subset,200);
        }
    }
}
