<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Image;
class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {               
        $setting = DB::table('settings')->first();
        return response()->json($setting);
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
        $data['vat'] = $request->vat;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $logo = $request->newlogo;

        if ($logo) {
         $position = strpos($logo, ';');
         $sub = substr($logo, 0, $position);
         $ext = explode('/', $sub)[1];

         $name = time().".".$ext;
         $img = Image::make($logo)->resize(38,37);
         $upload_path = 'backend/logo/';
         $image_url = $upload_path.$name;
         $success = $img->save($image_url);
         
         if ($success) {
            $data['logo'] = $image_url;
            $img = DB::table('settings')->where('id',$id)->first();
            $image_path = $img->logo;
            $done = unlink($image_path);
            $user  = DB::table('settings')->where('id',$id)->update($data);
         }
          
        }else{
            $oldphoto = $request->logo;
            $data['logo'] = $oldphoto;
            $user = DB::table('settings')->where('id',$id)->update($data);
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
        //
    }
}
