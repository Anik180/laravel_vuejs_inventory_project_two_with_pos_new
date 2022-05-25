<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class CartController extends Controller
{
    public function addToCart(Request $request,$id)
    {
        $product = DB::table('products')->where('id',$id)->first();
         
        $check  = DB::table('pos')->where('p_id',$id)->first();
         
         if ($check) {
         	DB::table('pos')->where('p_id',$id)->increment('p_qty');

		     $product = DB::table('pos')->where('p_id',$id)->first();
			 $sub_total = $product->p_qty * $product->p_price;
			 DB::table('pos')->where('p_id',$id)->update(['sub_total'=>$sub_total]);
         } else{
        $data = array();
    	$data['p_id'] = $id;
    	$data['p_name'] = $product->name;
    	$data['p_qty'] = 1;
    	$data['p_price'] = $product->selling_price;
    	$data['sub_total'] = $product->selling_price;
    	DB::table('pos')->insert($data);
         }



    }

    public function cartProduct(){
    	$cart = DB::table('pos')->get();
    	return response()->json($cart );
    }

    public function removeCart($id){
    	DB::table('pos')->where('id',$id)->delete();
    	return response('done');

    }

    public function increment($id){
        $qty = DB::table('pos')->where('id',$id)->increment('p_qty');

    	$product = DB::table('pos')->where('id',$id)->first();
    	$sub_total = $product->p_qty * $product->p_price;
    	DB::table('pos')->where('id',$id)->update(['sub_total'=>$sub_total]);
    	return response('Done');
    }
    public function decrement($id){
    	$qty = DB::table('pos')->where('id',$id)->decrement('p_qty');

    	$product = DB::table('pos')->where('id',$id)->first();
    	$sub_total = $product->p_qty * $product->p_price;
    	DB::table('pos')->where('id',$id)->update(['sub_total'=>$sub_total]);
    	return response('Done');
    }

    public function vat()
    {
        $vat = DB::table('settings')->first();
        return response()->json($vat);
    }
}
