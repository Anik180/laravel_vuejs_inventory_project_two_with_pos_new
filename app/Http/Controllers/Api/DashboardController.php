<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class DashboardController extends Controller
{
    public function todaySell(){
    	$date = date('d/m/Y');
    	$sell = DB::table('orders')->where('date',$date)->sum('total');
    	return response()->json($sell);
    }

    public function todayIncome(){
    	$date = date('d/m/Y');
    	$income = DB::table('orders')->where('date',$date)->sum('pay');
    	return response()->json($income);
    }

    public function todayDue(){
    	$date = date('d/m/Y');
    	$due = DB::table('orders')->where('date',$date)->sum('due');
    	return response()->json($due);
    }

    public function todayExpense(){
    	$date = date('d/m/Y');
    	$expenses = DB::table('expenses')->where('date',$date)->sum('amount');
    	return response()->json($expenses);
    }

  public function todayStockout(){

  $product = DB::table('products')->where('qty','<','1')->get();
  return response()->json($product);

 }
}
