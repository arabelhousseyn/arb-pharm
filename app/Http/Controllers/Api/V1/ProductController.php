<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsertProductRequest;
use App\Models\{Product, ProductImages, RequestEstimate, User};
use App\Notifications\NoReplayNotification;
use App\Traits\uploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Notification;
use Validator;
use function env;
use function response;
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
        $ids = [];

        $products = Product::select('id','description','user_id')->with('user')->latest('created_at')->get();

                if(Auth::user()->type == Product::clientA)
                {
                    foreach ($products as $product1) {
                        if($product1->user->type == Product::clientA)
                        {
                            $ids[] = $product1->id;
                        }
                    }
                }

                if(Auth::user()->type == Product::clientR)
                {
                    foreach ($products as $product1) {
                        if($product1->user->type == Product::clientA)
                        {
                            $ids[] = $product1->id;
                        }
                    }
                }

                if(Auth::user()->type == Product::clientB)
                {
                    foreach ($products as $product1) {
                        if($product1->user->type == Product::clientR)
                        {
                            $ids[] = $product1->id;
                        }
                    }
                }


        $data = Product::whereIn('id',$ids)->select('id','description','user_id')
            ->with('images:path,product_id','ratings:value,product_id','user.profile')
            ->latest('created_at')->paginate(7);
        $subset = $data->map(function($prod){
            return $prod->only(['id','description','rating','image','published_by']);
        });

        $data->setCollection($subset);
        return response($data,200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertProductRequest $request)
    {

        if($request->validated())
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
                $ids = [];
                foreach ($chunks as $chunk)
                {
                    $user_id_requests = RequestEstimate::where('product_name','LIKE',"%$chunk%")->pluck('user_id');
                    foreach ($user_id_requests as $user_id_request)
                    {
                        $ids[] = $user_id_request;
                        $user = User::find($user_id_request);
                        $product = Product::find($product->id);

                        $data = [
                            'name' => 'Nouvelle demande devis',
                            'body' => 'Découvrir les nouvelles produits qui s\'affichent pour votre demandes de devis',
                            'thanks' => 'Merci',
                            'data' => $product,
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
