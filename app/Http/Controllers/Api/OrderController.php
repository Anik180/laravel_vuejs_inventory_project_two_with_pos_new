<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DateTime;

class OrderController extends Controller
{
    public function todayOrder(){
       $data =  date('d/m/Y');
       $order = DB::table('orders')
                ->join('customers','orders.customer_id','customers.id')
                ->where('date',$data)
                ->select('customers.customer_name','orders.*')
                ->orderBy('orders.id','DESC')->get();
                return response()->json($order);
    }

    public function allOrder($id){
        $order = DB::table('orders')
        ->join('customers','orders.customer_id','customers.id')
        ->where('orders.id',$id)
        ->select('customers.customer_name','customers.email','customers.phone','customers.address','orders.*')
        ->first();
        return response()->json($order);
    }
    public function orderDetails($id){
        $details = DB::table('order_details')
        ->join('products','order_details.product_id','products.id')
        ->where('order_details.order_id',$id)
        ->select('products.name','products.code','products.photo','order_details.*')
        ->get();
        return response()->json($details);
    }

    public function searchOrder(Request $request){
      $orderDate = $request->date;
      $newdate = new DateTime($orderDate);
      $done = $newdate->format('d/m/Y');


      $order = DB::table('orders')
              ->join('customers','orders.customer_id','customers.id')
              ->select('customers.customer_name','orders.*')
              ->where('orders.date',$done)
              ->get();
      return response()->json($order);
    }
}
