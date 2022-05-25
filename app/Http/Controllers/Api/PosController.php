<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class PosController extends Controller
{
    public function getProduct($id)
    {
      $product = DB::table('products')
               ->where('category_id',$id)
               ->get();
               return response()->json($product);
    }

    public function orderDone(Request $request){
        $validateData = $request->validate([
         'customer_id' => 'required',
         'payBy' => 'required',
        ]);

        $data = array();
    	$data['customer_id'] = $request->customer_id;
    	$data['qty'] =  $request->qty;
    	$data['vat'] = $request->vat;
    	$data['subTotal'] = $request->subTotal;
    	$data['total'] = $request->total;
    	$data['pay'] = $request->pay;
    	$data['due'] = $request->due;
    	$data['payBy'] = $request->payBy;
    	$data['date'] = date('d/m/Y');
    	$data['month'] = date('F');
    	$data['year'] = date('Y');
    	$order_id = DB::table('orders')->insertGetId($data);

    	$contents = DB::table('pos')->get();

    	$odata = array();
    	foreach ($contents as $content) {
    		$odata['order_id'] = $order_id;
    		$odata['product_id'] = $content->p_id;
    		$odata['od_qty'] = $content->p_qty;
    		$odata['od_price'] = $content->p_price;
    		$odata['sub_total'] =$content->sub_total;
    		DB::table('order_details')->insert($odata);


    		DB::table('products')
    		    ->where('id',$content->p_id)
    		    ->update(['qty' => DB::raw('qty -' .$content->p_qty)]);
    	}
    	DB::table('pos')->delete();
    	return response('done');

    }
}
