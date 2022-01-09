<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductRating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $rules = [
            'product_id' => 'required',
            'value' => 'required'
        ];
        $validate = $request->validate($rules);
        if($validate)
        {
            $rate = false;
            $check = ProductRating::whereUserId(Auth::id())->whereProductId($request->product_id)->first();
            if($check)
            {
                $rate = ProductRating::whereId($check->id)->update([
                    'value' => $request->value
                ]);
            }else{
                $rate = ProductRating::insert([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'value' => $request->value
                ]);
            }
            if($rate)
            {
                return response(['success' => true],200);
            }else{
                return response(['success' => false],403);
            }
        }else{
            return response(['success' => false],403);
        }
    }
}
