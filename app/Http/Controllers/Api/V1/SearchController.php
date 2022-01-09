<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\{Product, UserProfile};
use Illuminate\Http\Request;
use function response;

class SearchController extends Controller
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
            'filter' => 'required'
        ];
        $validate = $request->validate($rules);
        if($validate)
        {
            $filter = $request->filter;

            $users = UserProfile::where('commercial_name','LIKE',"%$filter%")->select('id','commercial_name')->get();
            foreach ($users as $user)
            {
                $user['is_client'] = true;
            }
            $products = Product::where('description','LIKE',"%$filter%")->get();
            foreach ($products as $product)
            {
                $product['is_client'] = false;
            }

            $result = $users->merge($products);
            return response($result,200);
        }else{
            return response(['success' => false],403);
        }
    }
}
