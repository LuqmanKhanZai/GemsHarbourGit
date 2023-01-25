<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class SellerController extends Controller
{
    public function index()
    {
        // $sellers = User::seller()->with('store')->get();
        $sellers = User::where('store_status',1)->with('store')->get();
        return view('admin.seller.index', compact('sellers'));
    }

    public function store(SupplierRequest $request)
    {
        try{
            $data = array(
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => "0",
                'contact'  => $request->contact,
                'identity' => $request->identity,
                'address'  => $request->address,
                'type'     => 'Seller',
                'status'   => "Active",
            );
            $run = User::create($data);

            if ($run) {
                Alert::success('Success Title', $request->name. ' Added SuccessFully');
                return redirect()->route('seller.index');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function status(Request $request)
    {
        $row = User::where('id',$request->id)->first();
            if($row->status == 'Active')
            {
                $row->status = 'Disabled';
            }else{
                $row->status = 'Active';
            }
            $run = $row->update();
            if($run){
                return $rows = User::where('id',$request->id)->first();
            }
    }

    public function modal(Request $request)
    {
        return $row = User::where('id',$request->id)->first();
    }

    public function update(Request $request)
    {
        $row              = User::where('id',$request->id)->first();
        $row->name        = $request->name;
        $row->email = $request->email;
        $row->contact = $request->contact;
        // $row->identity = $request->identity;
        $row->address = $request->address;
        $run              = $row->update();
        if($run){
            return $row;
        }
    }
    
    
}
