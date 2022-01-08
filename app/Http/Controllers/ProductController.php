<?php

namespace App\Http\Controllers;

use App\Models\{Product, ProductImages, User,RequestEstimate};
use Illuminate\Http\Request;
use App\Traits\uploads;
use Auth,Validator,Notification;
use App\Notifications\NoReplayNotification;
class ProductController extends Controller
{
    use uploads;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::select('id','description','user_id')
            ->with('images:path,product_id','ratings:value,product_id','user.profile:id,commercial_name,user_id')
            ->orderBy('created_at', 'desc')->paginate(7);
        $subset = $product->map(function($prod){
            return $prod->only(['id','description','rating','image','published_by']);
        });
        $product->setCollection($subset);
        return response($product,200);
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
            'description' => 'required',
            'images' => 'required'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response(['success' => false],200);
        }

        if($validator->validated())
        {
            $pdf = null;
            if($request->has('technical_sheet_pdf'))
            {
                $pdf = $this->upload($request->technical_sheet_pdf,'technical_sheet','.pdf');
                $pdf = env('PATH_STORAGE') .'technical_sheet/'.$pdf;
            }

            $product = Product::create([
                'user_id' => Auth::id(),
                'description' => $request->description,
                'technical_sheet_pdf' => $pdf
            ]);
            if($product)
            {
                $images = explode(';',$request->images);
                foreach ($images as $image)
                {
                    $path = $this->upload($image,'product_image','.jpg');
                    $path = env('PATH_STORAGE') .'product_image/'.$path;
                    ProductImages::insert([
                        'product_id' => $product->id,
                        'path' => $path
                    ]);
                }

                $chunks = explode(' ',$request->description);
                foreach ($chunks as $chunk)
                {
                    $user_id_requests = RequestEstimate::where('product_name','LIKE',"%$chunk%")->pluck('user_id');
                    foreach ($user_id_requests as $user_id_request)
                    {
                        $user = User::find($user_id_request);
                        $product = Product::find($product->id)
                            ->only(['id', 'description', 'technical_sheet_pdf','rating','published_by','product_images','is_favorits','phone']);

                        $data = [
                            'name' => 'Nouvelle demande devis',
                            'body' => 'Découvrir les nouvelles produits qui s\'affichent pour votre demandes de devis',
                            'thanks' => 'Merci',
                            'data' => $product,
                        ];

                        Notification::send($user,new NoReplayNotification($data));
                    }
                }

                return response(['success' => true,'notified_ids' => $user_id_requests],200);
            }
            return response(['success' => false],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $subset = $product->only(['id', 'description', 'technical_sheet_pdf','rating','published_by','product_images','is_favorits','phone']);

        return response($subset,200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->deleteOrFail();
        return response(['success' => true],200);
    }

    public function getProductsByUser(User $user)
    {
        $data = Product::select('id','description','user_id','created_at','technical_sheet_pdf')->with('images')->latest()->whereUserId($user->id)->paginate(9);
        $subset = $data->map(function($value){
            return $value->only('id','description','images','technical_sheet_pdf','creation_date');
        });
        $data->setCollection($subset);
        return response($data,200);
    }

    public function getFavoritsProductsUser(User $user)
    {
        $data = User::with('favorites.product','favorites.product.images','favorites')->whereId($user->id)->first();
        $fav = $data->favorites;
        $fav = $fav->map(function($value){
            return $value->only('creation_date','product');
        });

        return response($fav,200);
    }

    public function getAllProducts()
    {
        $data = Product::with('images')->latest('id')->paginate(9);
        return response($data,200);
    }


}
