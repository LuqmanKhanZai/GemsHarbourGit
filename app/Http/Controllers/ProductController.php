<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductToImage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users    = User::all();
        $category = Category::active()->get();
        $products = Product::with('user:id,name,username','category:id,name','store:id,name','images')->get();
        return view('admin.product.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users    = User::all();
        $category = Category::active()->get();
        return view('admin.product.create', get_defined_vars());
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
            if($store){
                $request['store_id'] = $store->id;
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

                $run = Product::create($request->except('submit','images','start'));

                // if (request()->hasFile('images')) {
                //     $images = $request->file('images');
                //     foreach ($images as $key => $file) {
                //         $image = Image::make($request->file($file));
                //         $image->resize(null, 627, function ($constraint) {
                //             $constraint->aspectRatio();
                //         });
                //         $filename =  $image->getClientOriginalExtension();
                //         $image->save(public_path('images/product/' . time() . '.png'));

                //         ProductToImage::create([
                //             'product_id' => $run->id,
                //             'image' => $filename,
                //             'url' => $filename
                //         ]);
                //     }
                // }

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

                // foreach ($request->images as $key=>$image) {
                //     $iimage = Image::make($image)->resize(350, 150)->encode('jpg');

                //     Storage::disk('local')->put('public/images/' . $image->hashName(), (string)$iimage, 'public');

                //     $filename   = 'images/'. $image->hashName();
                //     ProductToImage::create([
                //         'product_id' => $run->id,
                //         'image' => $image->hashName(),
                //         'url' => $filename
                //     ]);
                // }

                // if($request->images) {
                //     $images = $request->file('images');
                //     foreach($images as $image) {
                //         $extension    = $image->getClientOriginalExtension();
                //         $filename     = time() . '.'.$extension;
                //         $image_resize = \Image::make($image->getRealPath());
                //         $image_resize->resize(427 ,320);
                //         $image_resize->save(public_path('images/product/'.$filename));
                //         $path = '/images/product/'.$filename;
                //         ProductToImage::create([
                //             'product_id' => $run->id,
                //             'image' => $filename,
                //             'url' => $path
                //         ]);
                //     }
                // }
                if($run){
                    Alert::success('Success Title', $request->title. ' Added SuccessFully');
                    return redirect()->route('product.index');
                }
            }else{
                Alert()->warning('WarningAlert','Please Add Store Again This User.');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }


    public function status(Request $request)
    {
        $row = Product::where('id',$request->chart_id)->first();
        if($row->status == 'Active')
        {
            $row->status = 'Disabled';
        }else{
            $row->status = 'Active';
        }
        $run = $row->update();
        if($run){
            return $rows = Product::where('id',$request->chart_id)->first();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users    = User::all();
        $category = Category::all();
        $product = Product::with('images')->find($id);
        return view('admin.product.edit',get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        // return $request->all();
        $row = Product::find($id);
        $row->user_id = $request->user_id;
        $row->category_id = $request->category_id;
        $row->title = $request->title;
        $row->description = $request->description;
        $row->dimension = $request->dimension;
        $row->dimension_x = $request->dimension_x;
        $row->dimension_y = $request->dimension_y;
        $row->weight = $request->weight;
        $row->certified = $request->certified;
        $row->clarity_i = $request->clarity_i;
        $row->clarity_if = $request->clarity_if;
        $row->clarity_si = $request->clarity_si;
        $row->clarity_vs = $request->clarity_vs;
        $row->clarity_vvs = $request->clarity_vvs;
        $row->no_treatment = $request->no_treatment;
        $row->listing_type = $request->listing_type;
        $row->duration = $request->duration;
        $row->item_type = $request->item_type;
        $row->starting_price = $request->starting_price;
        $row->reserve_price = $request->reserve_price;
        $row->offer = $request->offer;
        $row->start_date = $request->start_date;
        $row->shipping_details = $request->shipping_details;
        $row->shipping_price = $request->shipping_price;
        $row->shipping_cost = $request->shipping_cost;

        // foreach ($request->images as $key=>$image) {
        //     $iimage = Image::make($image)->resize(350, 150)->encode('jpg');

        //     Storage::disk('local')->put('public/images/' . $image->hashName(), (string)$iimage, 'public');

        //     $filename   = 'gallery_images/'. $image->hashName();
        //     ProductToImage::create([
        //         'product_id' => $id,
        //         'image' => $filename,
        //         'url' => $filename
        //     ]);
        // }

        if ($request->has('images')) {

            foreach($request->images as $key => $image){
                $filename    = $request->images[$key]->getClientOriginalName();
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(350,350);
                $image_resize->save(public_path('images/product/'.$filename));
                $url = 'images/product/'.$filename;
                ProductToImage::create([
                    'product_id' => $id,
                    'image'      => $filename,
                    'url'        => $url
                ]);
            }
        }

        // if($request->images) {
        //     $images = $request->file('images');
        //     foreach($images as $image) {
        //         $extension    = $image->getClientOriginalExtension();
        //         $filename     = time() . '.'.$extension;
        //         $image_resize = \Image::make($image->getRealPath());
        //         $image_resize->resize(427 ,320);
        //         $image_resize->save(public_path('images/product/'.$filename));
        //         $path = '/images/product/'.$filename;
        //         ProductToImage::create([
        //             'product_id' => $id,
        //             'image' => $filename,
        //             'url' => $path
        //         ]);
        //     }
        // }

        $run = $row->update();

        if($run){
            Alert::success('Success Title', $request->title. ' Update SuccessFully');
            return redirect()->route('product.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Product::find($id);
        $run = $row->delete();
        if ($run){
            Alert::success('Success Title', 'Product deleted SuccessFully');
                return redirect()->back();
        }
    }


    public function image_delete($id)
    {
        $row = ProductToImage::find($id);
        if($row)
        {
            $run = $row->delete();
            if($run){
                Alert::success('Success Title','Image Delete SuccessFully');
                    return redirect()->back();
            }
        }else{
            Alert::success('Success Title','No Image');
                    return redirect()->back();
        }
    }
}


