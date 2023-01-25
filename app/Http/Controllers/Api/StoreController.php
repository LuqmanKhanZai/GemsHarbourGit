<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $store   = Store::all();
            return response()->json([
                'data'        => $store,
                'status'      => 200,
                'message'     => 'Store Details Of User'
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Request Failed',
                'server_error' => $e->getMessage()
            ]);
        }
    }


    public function TotalStore()
    {
        try{
            $store   = Store::withCount('product')->get();
            return response()->json([
                'data'        => $store,
                'status'      => 200,
                'message'     => 'All Store Details'
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Request Failed',
                'server_error' => $e->getMessage()
            ]);
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $store = Store::where('user_id',$user->id)->first();
        if ($store) {
            return response()->json([
                'status'      => 403,
                'message'     => 'You Have Already One Store Contact Customer Support'
            ]);
        }

        $user->store_status = "1";
        $user->update();
        
        $rule = $request->validate([
            'name'    => 'required|min:1',
            'phone'   => 'required|min:1',
            'email'   => 'required|unique:stores',
            'address' => 'required',
            'image' => 'required',
        ]);
        try {
            if($request->image){
                $image        = $request->file('image');
                $extension    = $image->getClientOriginalExtension();
                $filename     = time() . '.'.$extension;
                $image_resize = \Image::make($image->getRealPath());
                $image_resize->resize(427 ,320);
                $image_resize->save(public_path('images/store/'.$filename));
                $url = '/images/store/'.$filename;
            }

            $request['image'] = $filename;
            $request['url']   = $url;
            $request['user_id'] = $user->id;
            $run = Store::create($request->all());
            if($run){
                return response()->json([
                    'data'        => $run,
                    'user'        => Auth::user()->load('store','card'),
                    'status'      => 200,
                    'message'     => 'Store Created Successfully',
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status'       => 500,
                'message'      => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_store(Request $request)
    {
       $row = Store::find($request->id);

       if (!$row){
            return response()->json([
                'status'      => 403,
                'message'     => 'NO store In against You',
            ]);
       }
       $row->name = $request->name;
       $row->email = $request->email;
       $row->phone = $request->phone;
       $row->country = $request->country;
       $row->address = $request->address;
       $row->city = $request->city;
       $row->state = $request->state;
       $row->website = $request->website;
       $row->is_register =$request->is_register;

       if($request->image){
            $image        = $request->file('image');
            $extension    = $image->getClientOriginalExtension();
            $filename     = time() . '.'.$extension;
            $image_resize = \Image::make($image->getRealPath());
            $image_resize->resize(427 ,320);
            $image_resize->save(public_path('images/store/'.$filename));
            $row->image = $filename;
            $row->url = '/images/store/'.$filename;
        }
       $run = $row->update();
       if($run){
            return response()->json([
                'user'        => Auth::user()->load('store','card'),
                'status'      => 200,
                'message'     => 'Store Updated Successfully',
            ]);
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
