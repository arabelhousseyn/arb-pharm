<?php

namespace App\Http\Controllers;

use App\Models\{
    UserProfile,
    UserActivityCode,
    User
};
use Illuminate\Http\Request;
use Auth,Validator;
class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function show(UserProfile $userProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(UserProfile $userProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserProfile $userProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProfile $userProfile)
    {
        //
    }


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
            return response(['success' => false],200);
        }
    }

    public function favoritesProducts()
    {
        $data = User::with('favorites.product')->find(Auth::id())->first();
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
