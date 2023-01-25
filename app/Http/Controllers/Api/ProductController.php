<?php

namespace App\Http\Controllers\Api;

use Image;
use App\Models\Store;
use App\Models\Product;
use App\Models\OrderSub;
use App\Models\BlockBider;
use Illuminate\Support\Str;
use App\Models\ProductToBid;
use Illuminate\Http\Request;
use App\Models\ProductToImage;
use App\Models\ProductToOffer;
use App\Models\ProductToWatch;
use App\Models\ProductToFeedback;
use App\Models\ProductToWishlist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $products         = Product::active()->with('images','category','store')->get();
            return response()->json([
                'data'        => $products,
                'status'      => 200,
                'message'     => 'All Product List',
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
    }

    public function ProductToUser()
    {
        try{
            $products         = Product::active()->where('user_id',Auth::user()->id)->with('images','category','store')->get();
            return response()->json([
                'data'        => $products,
                'status'      => 200,
                'message'     => 'User Product List',
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
    }


    // this function return Random Product
    public function RandomProduct(Request $request)
    {
        try{
            $products         = Product::active()->inRandomOrder()->limit(4)->with('category','images','store')->get();
            return response()->json([
                'data'        => $products,
                'status'      => 200,
                'message'     => 'Random Product List',
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Request Failed',
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
    public function store(ProductRequest $request)
    {
        try {
            $user = Auth::user();
            $store = Store::where('user_id',$user->id)->first();
            $request['store_id'] = $store->id;
            // $request['store_id'] = 1;
            $request['user_id'] = $user->id;

            if($request->cover) {
                $cover = $request->file('cover');
                $extension1    = $cover->getClientOriginalExtension();
                $filename1     = time() . '.'.$extension1;
                $image_resize1 = \Image::make($cover->getRealPath());
                $image_resize1->resize(427 ,320);
                $image_resize1->save(public_path('images/product/'.$filename1));
                $path1 = '/images/product/'.$filename1;
                $request['cover'] = $filename1;
                $request['url'] = $path1;
            }

            $run = Product::create($request->except('submit','images'));

            if ($request->has('images')) {

                foreach($request->images as $key => $image){
                    $filename    = $request->images[$key]->getClientOriginalName();
                    $image_resize = Image::make($image->getRealPath());
                    $image_resize->resize(350,350);
                    $image_resize->save(public_path('images/product/'.$filename));
                    $url = 'images/product/'.$filename;
                    ProductToImage::create([
                        'product_id' => $run->id,
                        'image'      => $filename,
                        'url'        => $url
                    ]);
                }
            }

            if($run){
                return response()->json([
                    'status'      => 200,
                    'message'     => 'Product Added Successfully',
                ]);
            }

        } catch (\Exception $e) {
            return $e->getMessage();
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
        $products = Product::find($id);
        return response()->json($products);

        // $list = [];
        // array_push($list, [
        // 'subcatgory'     => Mcategoryies::where('category_code', $data->parent_id)->select('category_code AS value', 'category_title AS label')->get(),
        // 'category_title' => $data->category_title,
        // 'category_image' => $data->category_image
        // ]);
        // return response()->json($list[0]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    public function update_product(ProductUpdateRequest $request)
    {
        $row                   = Product::find($request->id);
        $row->category_id      = $request->category_id;
        $row->title            = $request->title;
        $row->description      = $request->description;
        $row->dimension        = $request->dimension;
        $row->dimension_x      = $request->dimension_x;
        $row->dimension_y      = $request->dimension_y;
        $row->weight           = $request->weight;
        $row->certified        = $request->certified;
        $row->clarity_i        = $request->clarity_i;
        $row->clarity_if       = $request->clarity_if;
        $row->clarity_si       = $request->clarity_si;
        $row->clarity_vs       = $request->clarity_vs;
        $row->clarity_vvs      = $request->clarity_vvs;
        $row->no_treatment     = $request->no_treatment;
        $row->listing_type     = $request->listing_type;
        $row->duration         = $request->duration;
        $row->item_type        = $request->item_type;
        $row->starting_price   = $request->starting_price;
        $row->reserve_price    = $request->reserve_price;
        $row->offer            = $request->offer;
        $row->start_date       = $request->start_date;
        $row->shipping_details = $request->shipping_details;
        $row->shipping_price   = $request->shipping_price;
        $row->shipping_cost    = $request->shipping_cost;
        
         if($request->cover) {
                $cover = $request->file('cover');
                $extension1    = $cover->getClientOriginalExtension();
                $filename1     = time() . '.'.$extension1;
                $image_resize1 = \Image::make($cover->getRealPath());
                $image_resize1->resize(427 ,320);
                $image_resize1->save(public_path('images/product/'.$filename1));
                $path1 = '/images/product/'.$filename1;
                $row->cover = $filename1;
                $row->url = $path1;
            }

        // return $row;

        $run = $row->update();
        // return "000";
        if ($request->has('images')) {
            foreach($request->images as $key => $image){
                $filename    = $request->images[$key]->getClientOriginalName();
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(350,350);
                $image_resize->save(public_path('images/product/'.$filename));
                $url = 'images/product/'.$filename;
                ProductToImage::create([
                    'product_id' => $request->id,
                    'image'      => $filename,
                    'url'        => $url
                ]);
            }
        }

        // return "000";


        return response()->json([
            'status'      => 200,
            'message'     => 'Product Update Successfully',
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->status = $product->status ==  'Active' ? $product->status = 'Disabled' : $product->status = 'Active';
        $product->save();
        return response()->json(['msg' => $product->title. ' has been Deleted']);
    }

    public function ProductWatch(Request $request)
    {
        try {
            $count = ProductToWatch::where('product_id',$request->product_id)->
            where('user_id',Auth::user()->id)->first();
            if(!$count){
                $request['count'] = 1;
                $request['user_id'] = $user = Auth::user()->id;
                ProductToWatch::create($request->all());
                return response()->json([
                    'status'      => 200,
                    'message'     => 'Success',
                ]);
            }else{
                $watch = $count->count + 1;
                ProductToWatch::where('product_id',$request->product_id)->
                where('user_id',Auth::user()->id)->update([
                    'count' => $watch,
                ]);
                return response()->json([
                    'status'      => 200,
                    'message'     => 'Success',
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

    public function ProductWishlist(Request $request)
    {
        try {
            $count = ProductToWishlist::where('product_id',$request->product_id)
            ->where('user_id',Auth::user()->id)->first();
            if(!$count){
                $request['user_id'] = $user = Auth::user()->id;
                ProductToWishlist::create($request->all());
                return response()->json([
                    'status'      => 200,
                    'message'     => 'Product Add To Wishlist',
                ]);
            }else{
                ProductToWishlist::where('product_id',$request->product_id)->
                where('user_id',Auth::user()->id)->delete();
                return response()->json([
                    'status'      => 200,
                    'message'     => 'Product Remove To Wishlist',
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

    public function ProductWatchList()
    {
        try {
            $product_id = ProductToWatch::where('user_id',Auth::user()->id)->pluck('product_id');
            $watchitem = Product::whereIn('id',$product_id)->get();

            if(!$watchitem){
                return response()->json([
                    'status'      => 200,
                    'message'     => 'No WathcProduct',
                ]);
            }else{
                return response()->json([
                    'data'      => $watchitem,
                    'status'      => 200,
                    'message'     => 'Watch Product List',
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

    public function ProductFeedback(Request $request)
    {
        try {
            $request['user_id'] = $user = Auth::user()->id;
            ProductToFeedback::create($request->all());
            return response()->json([
                'status'      => 200,
                'message'     => 'FeedBack Added Successfuly',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'       => 500,
                'message'      => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
    }

    public function ProductOffer(Request $request)
    {
        try {
            $seller_id = Product::where('id',$request->product_id)->select('user_id')->first()->user_id;

            $checkblock = BlockBider::where('buyer_id',Auth::user()->id)
            ->where('seller_id',$seller_id)->first();
            if($checkblock){
                return response()->json(['message' => 'You can not offer on this Product']);
            }
            $request['user_id'] = $user = Auth::user()->id;
            ProductToOffer::create($request->all());
            return response()->json([
                'status'      => 200,
                'message'     => 'Offer Added Successfuly',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'       => 500,
                'message'      => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
    }

    public function UserProductOrder()
    {
        try {

            $orders = OrderSub::where('user_id',Auth::user()->id)->get();
            $list = [];
            foreach($orders as $order){

                array_push($list,[
                    'order_status' => $order->status,
                    'product' => Product::where('id',$order->product_id)->first(),
                ]);

            }

             if(!$list){
                return response()->json([
                    'status'  => 200,
                    'message' => 'No Win History',
                ]);
            }else{
                return response()->json([
                    'data'    => $list,
                    'status'  => 200,
                    'message' => 'Win History List',
                ]);
            }

            // $product_id = OrderSub::where('user_id',Auth::user()->id)->pluck('product_id');
            // $winproduct = Product::whereIn('id',$product_id)->get();
            // if(!$winproduct){
            //     return response()->json([
            //         'status'  => 200,
            //         'message' => 'No Win History',
            //     ]);
            // }else{
            //     return response()->json([
            //         'data'    => $winproduct,
            //         'status'  => 200,
            //         'message' => 'Win History List',
            //     ]);
            // }
        } catch (\Exception $e) {
            return response()->json([
                'status'       => 500,
                'message'      => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
    }


    public function UserProductFeedback()
    {
        try {
            $feedback = ProductToFeedback::where('user_id',Auth::user()->id)
            ->with('product')->get();

            if(!$feedback){
                return response()->json([
                    'status'      => 200,
                    'message'     => 'No Feedback',
                ]);
            }else{
                return response()->json([
                    'data'      => $feedback,
                    'status'      => 200,
                    'message'     => 'User Feedback List',
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

    public function ProductFeedbackList($id)
    {
        try {
            $feedback = ProductToFeedback::where('product_id',$id)
            ->get();

            if(!$feedback){
                return response()->json([
                    'status'      => 200,
                    'message'     => 'No Feedback',
                ]);
            }else{
                return response()->json([
                    'data'      => $feedback,
                    'status'      => 200,
                    'message'     => 'Feedback List',
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


    public function ProductSearch(Request $request)
    {
        try{
            $products         = Product::where('name', 'like', '%' . $request->product_name . '%')
            ->limit(4)->with('category','images','store')->get();
            return response()->json([
                'data'        => $products,
                'status'      => 200,
                'message'     => 'Random Product List',
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
    }

    public function ProductBid(Request $request)
    {
        try {
            $request['user_id'] = $user = Auth::user()->id;
            ProductToBid::create($request->all());
            return response()->json([
                'status'      => 200,
                'message'     => 'Bid Added Successfuly',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'       => 500,
                'message'      => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
    }

    public function SellerProductBid()
    {
        try {
            $product_id = Product::where('user_id',Auth::user()->id)->pluck('id');
            $bidproduct = ProductToBid::whereIn('product_id',$product_id)
            ->with('product:id,title,cover,url')->get();

            if(!$bidproduct){
                return response()->json([
                    'status'      => 200,
                    'message'     => 'No Bid Product',
                ]);
            }else{
                return response()->json([
                    'data'      => $bidproduct,
                    'status'      => 200,
                    'message'     => 'Bid Products List',
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


    public function BuyerProductBid()
    {
        try {
            $bidproduct = ProductToBid::where('user_id',Auth::user()->id)
            ->with('product')->get();
            if(!$bidproduct){
                return response()->json([
                    'status'      => 200,
                    'message'     => 'No Bid Product',
                ]);
            }else{
                return response()->json([
                    'data'      => $bidproduct,
                    'status'      => 200,
                    'message'     => 'Bid Products List',
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

    public function BidStatus(Request $request)
    {
        try {
            $bid = ProductToBid::where('id',$request->bid_id)->first();
            $bid->status = $request->status;
            $bid->update();
            return response()->json([
                'status'      => 200,
                'message'     => 'Bid Update Successfuly',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'       => 500,
                'message'      => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
    }

    public function OfferStatus(Request $request)
    {
        try {
            $bid = ProductToOffer::where('id',$request->offer_id)->first();
            $bid->status = $request->status;
            $bid->update();
            return response()->json([
                'status'      => 200,
                'message'     => 'Offer Update Successfuly',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'       => 500,
                'message'      => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
    }

    public function GetSellerOffer()
    {
        try {
            $product_id = Product::where('user_id',Auth::user()->id)->pluck('id');
            $bidproduct = ProductToOffer::whereIn('product_id',$product_id)
            ->with('product:id,title,cover,url')->get();

            if(!$bidproduct){
                return response()->json([
                    'status'      => 200,
                    'message'     => 'No Offer Product',
                ]);
            }else{
                return response()->json([
                    'data'      => $bidproduct,
                    'status'      => 200,
                    'message'     => 'Offers Products List',
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

    public function BuyerBlock(Request $request)
    {
        try {
            $request['seller_id'] = $user = Auth::user()->id;
            BlockBider::create($request->all());
            return response()->json([
                'status'      => 200,
                'message'     => 'User Block Successfuly',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'       => 500,
                'message'      => 'Request Failed',
                'server_error' => $e->getMessage(),
            ]);
        }
    }

    public function SellerProductFeedback()
    {
        try {
            $product_id = Product::where('user_id',Auth::user()->id)->pluck('id');
            $feedbackproduct = ProductToFeedback::whereIn('product_id',$product_id)
            ->with('product:id,title,cover,url')->get();

            if(!$feedbackproduct){
                return response()->json([
                    'status'      => 200,
                    'message'     => 'Sellere Product Feedback',
                ]);
            }else{
                return response()->json([
                    'data'      => $feedbackproduct,
                    'status'      => 200,
                    'message'     => 'No Feedback',
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
}
