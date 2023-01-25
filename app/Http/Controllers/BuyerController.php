<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\BuyerRequest;
use Alert;

class BuyerController extends Controller
{
    public function index()
    {
        // $buyers = User::buyer()->get();
        $buyers = User::where('store_status', '=', '0')->get();
        return view('admin.buyer.index', compact('buyers'));
    }

    public function store(BuyerRequest $request)
    {
        try{
            $data = array(
                'name'     => $request->name,
                'username'     => $request->username,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'p_text' => $request->password,
                'status'   => "Active",
            );
            $run = User::create($data);
            if ($run) {
                Alert::success('Success Title', $request->name. ' Added SuccessFully');
                return redirect()->route('buyer.index');
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
        $row           = User::where('id',$request->id)->first();
        $row->name     = $request->name;
        $row->email    = $request->email;
        $row->username = $request->username;
        $row->password = bcrypt($request->password);
        $row->p_text   = $request->password;
        $run           = $row->update();

        if($run){
            return $row;
        }
    }
}
