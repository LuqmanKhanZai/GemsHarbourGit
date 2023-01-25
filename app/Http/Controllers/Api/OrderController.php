<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderSub;
use App\Models\BlockBider;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function OrderList()
    {
        try {
            $order = Order::with('order_sub.product')->limit(5)->get();
            if(!$order){
                return response()->json([
                    'status'      => 200,
                    'message'     => 'No Order',
                ]);
            }else{
                return response()->json([
                    'data'      => $order,
                    'status'      => 200,
                    'message'     => 'Order List',
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

    public function SellerSale()
    {
        $user = Auth::user();
        $orderids = OrderSub::where('seller_id',$user->id)->pluck('order_id');
        $orders = Order::whereIn('id',$orderids)->orderBy('id', 'DESC')->get();
        $list = [];
        foreach($orders as $order)
        {
            $product = OrderSub::where('seller_id',$user->id)
            ->where('order_id',$order->id)->with('product')->get();
            $user =  User::where('id',$order->user_id)->select('id','username','email')->first();
            array_push($list,[
                'order' => $order,
                'user' => $user,
                'product' => $product,
            ]);
        }

        if(!$list){
            return response()->json([
                'status'      => 200,
                'message'     => 'No Sale List',
            ]);
        }else{
            return response()->json([
                'data'      => $list,
                'status'      => 200,
                'message'     => 'Sellere Sale List',
            ]);
        }

        // return $list;


        // $user = Auth::user();
        
        // $product_id = Product::where('user_id',Auth::user()->id)->pluck('id');


        // $userids = OrderSub::whereIn('product_id',$product_id)->pluck('user_id');

        // $products =  User::select('id','username','email')->whereIn('id',$userids)
        // ->with('saleproduct.product:id,title,cover,url,description,reserve_price')->get();



        // $products =  OrderSub::whereIn('product_id',$product_id)
        // ->with('user:id,username,email','product:id,title,cover,url')->get();

        // if(!$products){
        //     return response()->json([
        //         'status'      => 200,
        //         'message'     => 'No Sale List',
        //     ]);
        // }else{
        //     return response()->json([
        //         'data'      => $products,
        //         'status'      => 200,
        //         'message'     => 'Sellere Sale List',
        //     ]);
        // }
    }

    public function UserPurcahse($buyer_id)
    {
        $user =  User::where('id',$buyer_id)->first();
        $order = Order::where('user_id',$buyer_id)->with('order_sub.product')->get();
        $total_order = Order::where('user_id',$buyer_id)->count();
        $total_amount = Order::where('user_id',$buyer_id)->sum('total');

        if(!$user){
            return response()->json([
                'status'      => 200,
                'message'     => 'No Purchase Of This User',
            ]);
        }else{
            return response()->json([
                'user'      => $user,
                'order' =>$order,
                'total_order'      => $total_order,
                'total_amount'      => $total_amount,
                'status'      => 200,
                'message'     => 'PUrchase List',
            ]);
        }

    }

    // public function SellerSale(){
    //     $user = Auth::user();
    //     $product_id = Product::where('user_id',Auth::user()->id)->pluck('id');
    //     $products =  OrderSub::whereIn('product_id',$product_id)
    //     ->with('user:id,username,email','product:id,title,cover,url,reserve_price')->get();

    //     if(!$products){
    //         return response()->json([
    //             'status'      => 200,
    //             'message'     => 'No Sale List',
    //         ]);
    //     }else{
    //         return response()->json([
    //             'data'      => $products,
    //             'status'      => 200,
    //             'message'     => 'Sellere Sale List',
    //         ]);
    //     }
    // }


    public function BlockBuyer()
    {
        $user = BlockBider::where('seller_id',Auth::user()->id)->get();
        if(!$user){
            return response()->json([
                'status'      => 200,
                'message'     => 'No Block User List',
            ]);
        }else{
            return response()->json([
                'data'      => $user,
                'status'      => 200,
                'message'     => 'Block User List',
            ]);
        }
    }

    public function BlockBuyerDelete($buyer_id)
    {
        $user = BlockBider::where('id',$buyer_id)->first();

        // $user = BlockBider::where('seller_id',Auth::user()->id)
        // ->where('buyer_id',$buyer_id)->first();

        if(!$user){
            return response()->json([
                'message'     => 'No Block User',
            ]);
        }else{
            $user->delete();
            return response()->json([
                'data'      => $user,
                'status'      => 200,
                'message'     => 'Block User List',
            ]);
        }
    }


    public function SellerSaleStatus(Request $request)
    {
        try {
            $bid = OrderSub::where('id',$request->id)->first();
            $bid->status = $request->status;
            $bid->update();
            return response()->json([
                'status'      => 200,
                'message'     => 'Status Update Successfuly',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'       => 500,
                'message'      => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
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
        $user = Auth::user();
        $rule = $request->validate([
            'category'    => 'required|min:1',
            'insurance'   => 'required|min:1',
            'item_total'   => 'required',
            'shipping' => 'required',
            'postal_insurance' => 'required',
            'sub_total' => 'required',
            'total' => 'required',
        ]);
        try {
            $request['user_id'] = $user->id;
            $run = Order::create($request->except('product_id'));
            foreach($request->product_id as $item_id){
                $sellerDetails = Product::where('id',$item_id)->first();
                $order_sub = array(
                    'order_id' => $run->id,
                    'product_id' => $item_id,
                    'user_id' => $user->id,
                    'store_id' => $sellerDetails->store_id,
                    'seller_id' => $sellerDetails->user_id,
                );
                OrderSub::create($order_sub);
            }
            if($run){
                return response()->json([
                    'status'      => 200,
                    'message'     => 'Order Has Been Addedd Successfully',
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
