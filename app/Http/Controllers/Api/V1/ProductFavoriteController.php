<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFavoritProductRequest;
use App\Models\ProductFavorite;
use App\Models\ProductUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductFavoriteController extends Controller
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
    public function store(StoreFavoritProductRequest $request)
    {
        $check= ProductUser::where([['user_id','=',Auth::id()],['product_id','=',$request->product_id]])->first();
        if($check)
        {
            return response(['message' => 'already exists'],403);
        }

        ProductUser::create([
            'user_id'=> Auth::id(),
            'product_id' => $request->product_id
        ]);

        return response(['success' => true],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductFavorite  $productFavorite
     * @return \Illuminate\Http\Response
     */
    public function show(ProductFavorite $productFavorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductFavorite  $productFavorite
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductFavorite $productFavorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductFavorite  $productFavorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductFavorite $productFavorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductFavorite  $productFavorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductFavorite $productFavorite)
    {
        //
    }
}
