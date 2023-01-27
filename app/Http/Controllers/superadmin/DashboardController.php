<?php

namespace App\Http\Controllers\superadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Expence;
use App\Orderdetails;
use Carbon\Carbon;
class DashboardController extends Controller
{
    
  public function index(Request $request){
        if($request->filter && $request->start && $request->end){
            $start = $request->start;
            $end = $request->end;
            $query = $request->filter;
        }elseif($request->filter && $request->start==NULL && $request->end==NULL){
            $query = $request->filter;
            $start = NULL;
            $end = NULL;
        }else{
            $query = 1;
            $start = NULL;
            $end = NULL;
        }
        $todayexpence = Expence::whereDate('created_at',Carbon::today())->sum('ammount');
        $totalstock = Product::sum('proQuantity');
        $todaysalesamount = Orderdetails::whereDate('created_at',Carbon::today())->get()->sum(function($stotal){
                return $stotal->productPrice * $stotal->productQuantity; });
        return view('backEnd.superadmin.dashboard',compact('query','start','end','todayexpence','totalstock','todaysalesamount'));
    	
    }
}
