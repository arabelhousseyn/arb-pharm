<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\{Product, RequestEstimate, User, UserProfile};
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
            $data1 = [];
            $data2 = [];
            $data3 = [];
            $filter = $request->filter;
            if(Auth::user()->type == User::clientA)
            {

                $users = UserProfile::with('user')->where('commercial_name','LIKE',"%$filter%")->select('id','commercial_name')->get();
                foreach ($users as $user)
                {
                    $user['type'] = 'CLIENT';
                    if($user->user->type == User::clientR)
                    {
                        $data1[] = $user;
                    }
                }
                $requests = RequestEstimate::with('user')->where('product_name','LIKE',"%$filter%")->get();
                foreach ($requests as $request)
                {
                    $request['type'] = 'REQUEST';
                    if($request->user->type == User::clientR)
                    {
                        $data2[] = $request;
                    }
                }

                $products = Product::with('user')->where('description','LIKE',"%$filter%")->get();
                foreach ($products as $product) {
                    $product['type'] = 'PRODUCT';
                    if($product->user->type == User::clientA)
                    {
                        $data3[] = $product;
                    }
                }


                $result = [
                    'clients' => $data1,
                    'requests'=> $data2,
                    'products' => $data3
                ];

                return response($result,200);
            }

            if(Auth::user()->type == User::clientR)
            {

                $users = UserProfile::with('user')->where('commercial_name','LIKE',"%$filter%")->select('id','commercial_name')->get();
                foreach ($users as $user)
                {
                    $user['type'] = 'CLIENT';
                    if($user->user->type == User::clientB || $user->user->type == User::clientA)
                    {
                        $data1[] = $user;
                    }
                }
                $requests = RequestEstimate::with('user')->where('product_name','LIKE',"%$filter%")->get();
                foreach ($requests as $request)
                {
                    $request['type'] = 'REQUEST';
                    if($request->user->type == User::clientB)
                    {
                        $data2[] = $request;
                    }
                }

                $products = Product::with('user')->where('description','LIKE',"%$filter%")->get();
                foreach ($products as $product) {
                    $product['type'] = 'PRODUCT';
                    if($product->user->type == User::clientA)
                    {
                        $data3[] = $product;
                    }
                }

                $result = [
                    'clients' => $data1,
                    'requests' => $data2,
                    'products' => $data3
                ];

                return response($result,200);
            }

            if(Auth::user()->type == User::clientB)
            {

                $users = UserProfile::with('user')->where('commercial_name','LIKE',"%$filter%")->select('id','commercial_name')->get();
                foreach ($users as $user)
                {
                    $user['type'] = 'CLIENT';
                    if($user->user->type == User::clientR)
                    {
                        $data1[] = $user;
                    }
                }
                $products = Product::with('user')->where('description','LIKE',"%$filter%")->get();
                foreach ($products as $product)
                {
                    $product['type'] = 'PRODUCT';
                    if($product->user->type == User::clientR)
                    {
                        $data2[] = $product;
                    }
                }

                $result = [
                    'clients' => $data1,
                    'products' => $data2
                ];

                return response($result,200);
            }
            return response()->noContent();
        }else{
            return response(['success' => false],403);
        }
    }
}
