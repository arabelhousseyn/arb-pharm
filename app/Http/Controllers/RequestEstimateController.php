<?php

namespace App\Http\Controllers;

use App\Models\{
    RequestEstimate,
    RequestEstimateImage
};
use Illuminate\Http\Request;
use Auth,Validator;
use App\Traits\uploads;
class RequestEstimateController extends Controller
{
    use uploads;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RequestEstimate::select('id','product_name','amount','user_id')->orderBy('created_at','desc')
            ->get();
        $subset = $data->map(function($req){
            return $req->only(['id','product_name','amount','image','publishedBy']);
        });
        return response($subset,200);
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
        $rules = [
            'product_name' => 'required',
            'amount' => 'required',
            'mark' => 'required',
            'images' => 'required'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response(['success' => false],200);
        }

        if($validator->validated())
        {
            $estimate = RequestEstimate::create([
                'user_id' => Auth::id(),
                'product_name' => $request->product_name,
                'amount' => $request->amount,
                'mark' => $request->mark
            ]);
            if($estimate)
            {
                $images = explode(';',$request->images);
                try {
                    foreach ($images as $image)
                    {
                        $path  = $this->upload($image,'request_estimate','.jpg');
                        $path = env('path_storage') . 'request_estimate/' . $path;
                        RequestEstimateImage::insert([
                            'request_estimate_id' => $estimate->id,
                            'path' => $path
                        ]);
                    }
                }catch (Exception $exception)
                {
                    return response(['success' => false],200);
                }
                return response(['success' => true],200);
            }
            return response(['success' => false],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestEstimate  $requestEstimate
     * @return \Illuminate\Http\Response
     */
    public function show(RequestEstimate $requestEstimate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestEstimate  $requestEstimate
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestEstimate $requestEstimate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestEstimate  $requestEstimate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestEstimate $requestEstimate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestEstimate  $requestEstimate
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestEstimate $requestEstimate)
    {
        //
    }
}
