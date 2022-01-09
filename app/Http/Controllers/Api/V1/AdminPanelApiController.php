<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\{Admin, Product, RequestEstimate, User};
use Auth;
use Carbon\Carbon;
use function response;

class AdminPanelApiController extends Controller
{
    public function getInformations()
    {
        $count_admins = Admin::where('id','<>',Auth::id())->count();
        $count_users = User::count();
        $products = Product::count();
        $request_estimate = RequestEstimate::count();
        $data = [
            ['value' => $count_admins,'title' => 'Administrateurs', 'icon' => 'mdi-account'],
            ['value' => $count_users,'title' => 'Utilisateurs', 'icon' => 'mdi-account'],
            ['value' => $products,'title' => 'Produits', 'icon' => 'mdi-package-variant'],
            ['value' => $request_estimate,'title' => 'Demandes de devis', 'icon' => 'mdi-hand-heart']
        ];

        return response($data,200);
    }

    public function graph()
    {
        $data = User::all();
        $months = [1,2,3,4,5,6,7,8,9,10,11,12];
        $currentYear = Carbon::now()->year;
        $final = array();
        foreach ($months as $month)
        {
            $count = 0;
        foreach ($data as $value)
        {
            $year = Carbon::parse($value->created_at)->year;
            if($currentYear == $year)
            {
                $userMonth = Carbon::parse($value->created_at)->month;
                    if(intval($month) == intval($userMonth))
                    {
                        $count++;
                    }
                }
            }
        $final[] = $count;
        }
        return response($final,200);
    }
}
