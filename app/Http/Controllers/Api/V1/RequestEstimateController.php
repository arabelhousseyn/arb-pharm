<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;
use App\Http\Requests\InsertRequestEstimateRequest;
use App\Models\{Product, RequestEstimate, RequestEstimateImage, User};
use App\Notifications\NoReplayNotification;
use App\Traits\uploads;
use Auth;
use Illuminate\Http\Request;
use Notification;
use Validator;
use function env;
use function response;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertRequestEstimateRequest $request)
    {

        if($request->validated())
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
                        $path = env('PATH_STORAGE') . 'request_estimate/' . $path;
                        RequestEstimateImage::insert([
                            'request_estimate_id' => $estimate->id,
                            'path' => $path
                        ]);
                    }
                }catch (Exception $exception)
                {
                    return response(['success' => false],200);
                }

                $chunks = explode(' ',$request->product_name);
                $ids = [];
                foreach ($chunks as $chunk)
                {
                    $user_id_products = Product::where('description','LIKE',"%$chunk%")->pluck('user_id');
                    foreach ($user_id_products as $user_id_product)
                    {
                        $ids[] = $user_id_product;
                        $user = User::find($user_id_product);
                        $request_estimate = RequestEstimate::find($estimate->id);

                        $data = [
                            'name' => 'Nouvelle demande devis',
                            'body' => 'Découvrir les nouvelles demandes de devis qui s\'affichent pour votre produits',
                            'thanks' => 'Merci',
                            'data' => $request_estimate,
                        ];

                        Notification::send($user,new NoReplayNotification($data));
                    }
                }


                return response(['success' => true,'notified_ids' => $ids],200);
            }
            return response(['success' => false],403);
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
    public function destroy($request_estimate_id)
    {
       RequestEstimate::whereId($request_estimate_id)->delete();
       return response(['success' => true],200);
    }

    public function getRequestEstimateByUser(User $user)
    {
        $data = RequestEstimate::with('images')->latest()->whereUserId($user->id)->paginate(9);
        $subset = $data->map(function($value){
            return $value->only('id','amount','images_request','is_available','mark','product_name','creation_date');
        });
        $data->setCollection($subset);
        return response($data,200);
    }

    public function getAllRequestsEstimate()
    {
        $data = RequestEstimate::with('images')->latest('id')->paginate(9);
        return response($data,200);
    }

}
