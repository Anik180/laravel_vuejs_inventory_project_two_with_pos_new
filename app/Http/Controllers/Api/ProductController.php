<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Product;
use Image;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = DB::table('products')
                    ->join('categories','products.category_id','categories.id')
                    ->join('suppliers','products.supplier_id','suppliers.id')
                    ->select('categories.category_name','suppliers.supplier_name','products.*')
                    ->orderBy('products.id','DESC')
                    ->get();
                    return response()->json($product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
         'name' => 'required',
         'code' => 'required|unique:products',
         'buying_price' => 'required',
         'selling_price' => 'required',
         'buying_date' => 'required',
         'qty' => 'required',
         'category_id' => 'required',
         'supplier_id' => 'required',
       ]);

            if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo,0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().".".$ext;
            $img = Image::make($request->photo)->resize(240,200);
            $upload_path = 'backend/product/';
            $image_url = $upload_path. $name;
            $img->save($image_url);

            $product =new Product;
            $product->category_id = $request->category_id;
            $product->supplier_id = $request->supplier_id;
            $product->name = $request->name;
            $product->code = $request->code;
            $product->root = $request->root;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->buying_date = $request->buying_date;
            $product->qty = $request->qty;
            $product->photo = $image_url;
            $product->save();
        }else
        {
            $product =new Product;
            $product->category_id = $request->category_id;
            $product->supplier_id = $request->supplier_id;
            $product->name = $request->name;
            $product->code = $request->code;
            $product->root = $request->root;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->buying_date = $request->buying_date;
            $product->qty = $request->qty;
            $product->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array();
        $data['category_id'] = $request->category_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['name'] = $request->name;
        $data['code'] = $request->code;
        $data['root'] = $request->root;
        $data['buying_price'] = $request->buying_price;
        $data['selling_price'] = $request->selling_price;
        $data['buying_date'] = $request->buying_date;
        $data['qty'] = $request->qty;
        $image = $request->newphoto;

        if ($image) {
         $position = strpos($image, ';');
         $sub = substr($image, 0, $position);
         $ext = explode('/', $sub)[1];

         $name = time().".".$ext;
         $img = Image::make($image)->resize(240,200);
         $upload_path = 'backend/product/';
         $image_url = $upload_path.$name;
         $success = $img->save($image_url);
         
         if ($success) {
            $data['photo'] = $image_url;
            $img = DB::table('products')->where('id',$id)->first();
            $image_path = $img->photo;
            $done = unlink($image_path);
            $user  = DB::table('products')->where('id',$id)->update($data);
         }
          
        }else{
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
            $user = DB::table('products')->where('id',$id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $photo = $product->photo;
        if($photo){
            unlink($photo);
            DB::table('products')->where('id', $id)->delete();
        }else{
            DB::table('products')->where('id', $id)->delete();
        }
    }

    public function updateStock(Request $request,$id)
    {
        $data = array();
        $data['qty'] = $request->qty;
        DB::table('products')->where('id',$id)->update($data);
    } 
}
