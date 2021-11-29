<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class checkAppVersionController extends Controller
{
    public function index()
    {
       $data = DB::table('useful_data')->where('idname','app1_v')->first();
       return response((array)$data,200);
    }
}
